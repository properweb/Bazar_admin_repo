<?php

namespace Modules\Retailer\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Country\Entities\Country;
use Modules\Country\Entities\State;
use Modules\Country\Entities\City;
use Modules\Login\Entities\User;
use Modules\Retailer\Entities\Retailer;
use Modules\Category\Entities\Category;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RetailerService
{
    /**
     * Show All Retailer
     *
     * @param $request
     * @return array
     */
    public function retailerData($request): array
    {
        $catID = $request->catID;
        $country = $request->countrySelect;
        $state = $request->stateSelect;
        $city = $request->citySelect;
        $retailers = User::where('role', '=', ROLE::ROLE_RETAILER)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('retailers');
            })->with('retailer');

        if (!empty($country)) {
            $retailers->whereHas('retailer', function ($query) use ($country) {

                $query->where('country', $country);
            });
        }
        if (!empty($state)) {
            $retailers->whereHas('retailer', function ($query) use ($state) {
                $query->where('state', $state);
            });
        }
        if (!empty($city)) {
            $retailers->whereHas('retailer', function ($query) use ($city) {

                $query->where('town', $city);
            });
        }

        if (!empty($catID)) {
            $retailers->whereHas('cart', function ($query) use ($catID) {
                $query->whereHas('product', function ($query) use ($catID) {
                    $query->where('main_category', $catID);
                });
            })->with(['cart.product', 'retailer' => function ($query) {
                $query->select('user_id');
            }])->with('retailer');
        }

        $filteredCount = $retailers->count();

        $start = $request->start ?? 0;
        $length = $request->length ?? 0;
        $retailers = $retailers->offset($start)->limit($length);
        $result = DataTables::of($retailers)
            ->addIndexColumn()
            ->addColumn('store_name', function ($row) {
                return $row->retailer->store_name;
            })
            ->addColumn('store_type', function ($row) {
                return $row->retailer->store_type;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . url('/retailer/details/' . $row->id) . '"><span class="fas fa-eye"></span></a>  <a href="' . url('/order/retailer-order/' . $row->id) . '"><span class="fas fa-file-invoice-dollar"></span></a>  <a href="javascript:void(0)" onclick="event.preventDefault(); confirmDelete(' . $row->id . ');"><span class="fas fa-trash"></span></a> ';
            })
            ->rawColumns(['action'])
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;
    }

    /**
     * Details of retailer
     *
     * @param $id
     * @return mixed
     */
    public function detail($id): mixed
    {
        $userRetailer = User::with('retailer')->findOrFail($id);
        $detail = $userRetailer->retailer;

        $city = City::findOrFail($userRetailer->retailer->town);
        $state = $city->state;
        $cityName = $city->name;
        $stateName = $city->state->name;
        $countryName = $state->country->name;


        $detail['name'] = $userRetailer->first_name . ' ' . $userRetailer->last_name;
        $detail['email'] = $userRetailer->email ?? '';
        $detail['country'] = $countryName ?? '';
        $detail['state'] = $stateName ?? '';
        $detail['town'] = $cityName ?? '';
        $detail['shipping'] = $userRetailer->shippings;

        return $detail;
    }

    /**
     * Show Brand in Website
     *
     * @param $id
     * @param $status
     * @return array
     */
    public function changeStatus($id, $status): array
    {
        $user = User::find($id);
        $user->active = $status;
        $user->save();

        return [
            'res' => true,
            'msg' => '',
            'data' => ''
        ];
    }

    /**
     * Delete Retailer
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
        $countries = Country::select('id', 'shortname', 'name', 'phonecode')->get();
        $data = $countries->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'country_code' => $item->shortname,
                'country_name' => $item->name,
                'phone_code' => $item->phonecode,
            ];
        })->toArray();

        return $data;
    }

    /**
     * Create New Retailer
     *
     * @param array $retailerData
     * @param $request
     * @return string
     */
    public function createRetailer(array $retailerData, $request): string
    {

        $retailerData["retailer_key"] = 'r_' . Str::lower(Str::random(10));
        $password = $retailerData['password'];
        $document = $request->file('proof_document');
        $tempPath = $document->store('temp', 'public');
        $destinationPath = '../public/uploads/retailers/';
        $newFileName = time() . '_' . $document->getClientOriginalName();
        $document->move($destinationPath, $newFileName);
        \Storage::disk('public')->delete($tempPath);

        $user = new User();
        $user->first_name = $retailerData["first_name"];
        $user->last_name = $retailerData["last_name"];
        $user->email = $retailerData["email"];
        $user->password = Hash::make($retailerData['password']);
        $user->role = ROLE::ROLE_RETAILER;
        $user->verified = User::USER_ACTIVE;
        $user->active = User::USER_ACTIVE;
        $user->save();

        $retailer = new Retailer();
        $retailer->user_id = $user->id;
        $retailer->retailer_key = $retailerData["retailer_key"];
        $retailer->country_code = $retailerData["country_code"];
        $retailer->country = $retailerData["country"];
        $retailer->state = $retailerData["state"];
        $retailer->town = $retailerData["city"];
        $retailer->post_code = $retailerData["post_code"];
        $retailer->address1 = $retailerData["address1"];
        $retailer->phone_number = $retailerData["phone_number"];
        $retailer->language = $retailerData["language"];
        $retailer->store_name = $retailerData["store_name"];
        $retailer->store_type = $retailerData["store_type"];
        $retailer->website_url = $retailerData["website_url"];
        $retailer->proof_document = 'uploads/retailers/' . $newFileName;
        $retailer->save();

        $sender = [
            'address' => config('app.from_email'),
            'name' => 'Bazaar',
        ];
        $recipient = $retailerData['email'];
        $subject = 'Bazar:Your account has been created';
        $view = 'retailer_email';
        $data = [
            'first_name' => $retailerData["first_name"],
            'email' => $retailerData['email'],
            'password' => $password,
            'webUrl' => config('app.web_url')
        ];

        sendEmail($sender, $recipient, $subject, $view, $data);

        return true;
    }

    /**
     * Get a listing of only main product categories
     *
     * @return array
     */
    public function getCategory(): array
    {
        $data = [];
        $mainCategories = Category::select('title', 'id')->where('parent_id', 0)->where('status', '1')->orderBy('title', 'ASC')->get();
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
}
