<?php

namespace Modules\Brand\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Brand\Entities\Brand;
use Modules\Login\Entities\User;
use Modules\Category\Entities\Category;
use Modules\Country\Entities\Country;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Country\Entities\State;
use Modules\Country\Entities\City;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class BrandService
{
    /**
     * Show All Brand
     *
     * @param $request
     * @return array
     */
    public function brandData($request): array
    {

        $brands = User::where('role', '=', ROLE::ROLE_BRAND)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('brands');
            })
            ->with('profile');
        $filteredCount = $brands->count();
        $start = $request->start ?? 0;
        $length = $request->length ?? 0;
        $brands = $brands->offset($start)->limit($length);
        $result = DataTables::of($brands)
            ->addIndexColumn()
            ->addColumn('brand_name', function ($row) {
                return $row->profile->brand_name;
            })
            ->addColumn('go_live', function ($row) {
                return $row->profile->go_live;
            })
            ->addColumn('phone_number', function ($row) {
                return $row->profile->phone_number;
            })
            ->addColumn('action', function ($row) {
                return '<a href="'.url('/brand/details/' . $row->id).'"><span class="fas fa-eye"></span></a> <a href="'.url('/product/' . $row->id).'"><span class="fas fa-list"></span></a>  <a href="javascript:void(0)" onclick="event.preventDefault(); confirmDelete('.$row->id.');"><span class="fas fa-trash"></span></a> ';
            })
            ->rawColumns(['action'])
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;
    }

    /**
     * Details of brand
     *
     * @param $id
     * @return mixed
     */
    public function detail($id): mixed
    {

        $brand = User::findOrFail($id);
        $detail = $brand->profile;
        $category = Category::where('id',$detail->prime_cat)->first();
        $headQuarter = Country::where('id',$detail->headquatered)->first();
        $productMade = Country::where('id',$detail->product_made)->first();
        $productShipped = Country::where('id',$detail->product_shipped)->first();

        $detail['name'] = $brand->first_name.' '.$brand->last_name;
        $detail['email'] = $brand->email ?? '';
        $detail['prime-category'] = $category->title ?? '';
        $detail['head-quarter'] = $headQuarter->name ?? '';
        $detail['product-made'] = $productMade->name ?? '';
        $detail['product-shipped'] = $productShipped->name ?? '';

        return $detail;
    }

    /**
     * Delete Brand
     *
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $user = User::findOrFail($id);
        $user->delete();
        return [
            'res' => true,
            'msg' => 'Successfully deleted',
            'data' => ''
        ];
    }

    /**
     * Get all country
     *
     * @return array
     */
    public function getCountry(): array
    {
        $countries = Country::orderBy('name', 'ASC')->get();
        $data = array();
        foreach ($countries as $v) {
            $data[] = array(
                'id' => $v->id,
                'country_code' => $v->shortname,
                'country_name' => $v->name,
                'phone_code' => $v->phonecode
            );
        }

        return $data;
    }

    /**
     * Get a listing of only main product categories
     *
     * @return array
     */
    public function getCategory(): array
    {
        $data = [];
        $mainCategories = Category::where('parent_id', 0)->where('status', '1')->orderBy('title', 'ASC')->get();
        if ($mainCategories) {
            foreach ($mainCategories as $mainCategory) {
                $data[] = array(
                    'category' => $mainCategory->title,
                    'cat_id' => $mainCategory->id
                );
            }
        }

        return $data;
    }

    /**
     * Get all state by county
     *
     * @param $request
     * @return array
     */
    public function getState($request): array
    {

        $states = State::where('country_id',$request->countryId)->orderBy('name', 'ASC')->get();
        $data = array();
        foreach ($states as $state) {
            $data[] = array(
                'id' => $state->id,
                'name' => $state->name
            );
        }

        return $data;
    }

    /**
     * Get all city by state
     *
     * @param $request
     * @return array
     */
    public function getCity($request): array
    {
        $cities = City::where('state_id',$request->stateId)->orderBy('name', 'ASC')->get();

        $data = array();
        foreach ($cities as $city) {
            $data[] = array(
                'id' => $city->id,
                'name' => $city->name
            );
        }

        return $data;
    }

    /**
     * Create New Brand
     *
     * @param array $brandData
     * @param $request
     * @return string
     */
    public function createBrand(array $brandData,$request): string
    {

        $brandData["brand_key"] = 'bmc_' . Str::lower(Str::random(10));
        $slug = Str::slug($brandData["brand_name"], '-');
        $count = Brand::where(DB::raw('lower(brand_name)'), strtolower($brandData["brand_name"]))->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count+1);
        }
        $password = $brandData['password'];
        $brandData["brand_slug"] = $slug;
        $brandData["bazaar_direct_link"] = $slug;

        $document = $request->file('document');
        $tempPath = $document->store('temp', 'public');
        $destinationPath = '../public/uploads/documents/';
        $newFileName = time() . '_' . $document->getClientOriginalName();
        $document->move($destinationPath, $newFileName);
        \Storage::disk('public')->delete($tempPath);

        $user = new User();
        $user->first_name = $brandData["first_name"];
        $user->last_name = $brandData["last_name"];
        $user->email = $brandData["email"];
        $user->password = Hash::make($brandData['password']);
        $user->role = ROLE::ROLE_BRAND;
        $user->save();

        $brand = new Brand();
        $brand->user_id = $user->id;
        $brand->brand_key = $brandData["brand_key"];
        $brand->brand_email = $brandData["brand_email"];
        $brand->brand_name = $brandData["brand_name"];
        $brand->brand_slug  = $brandData["brand_slug"];
        $brand->bazaar_direct_link = $brandData["bazaar_direct_link"];
        $brand->about_us = $brandData["about_us"];
        $brand->num_store = $brandData["num_store"];
        $brand->prime_cat = $brandData["prime_cat"];
        $brand->website_url = $brandData["website_url"];
        $brand->country_code = $brandData["country_code"];
        $brand->country = $brandData["country"];
        $brand->phone_number = $brandData["phone_number"];
        $brand->language = $brandData["language"];
        $brand->headquatered = $brandData["headquatered"];
        $brand->established_year = $brandData["established_year"];
        $brand->insta_handle = $brandData["insta_handle"];
        $brand->city = $brandData["city"];
        $brand->state = $brandData["state"];
        $brand->product_made = $brandData["product_made"];
        $brand->product_shipped = $brandData["product_shipped"];
        $brand->num_products_sell = $brandData["num_products_sell"];
        $brand->document = 'uploads/documents/'.$newFileName;


        $brand->save();

        $webUrl = config('app.web_url');
        Mail::send('brand_email', ['webUrl' => $webUrl, 'first_name' => $brandData["first_name"],'email' => $brandData["email"],'password' => $password], function ($message) use ($brandData) {
            $message->to($brandData['email']);
            $message->from(config('app.from_email'));
            $message->subject('Bazar:Your account has been created');
        });

        return true;
    }

    /**
     * Show Brand in Website
     *
     * @param $id
     * @return array
     */
    public function live($id): array
    {
       $user = User::find($id);
       Brand::where('user_id', $id)->update(['go_live' => User::BRAND_LIVE]);

        $webUrl = config('app.web_url');
        Mail::send('live_email', ['webUrl' => $webUrl, 'first_name' => $user->first_name], function ($message) use ($user) {
            $message->to($user->email);
            $message->from(config('app.from_email'));
            $message->subject('Bazar:Your shop has been live');
        });

        return [
            'res' => true,
            'msg' => '',
            'data' => ''
        ];
    }
}
