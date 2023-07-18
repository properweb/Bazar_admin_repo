<?php

namespace Modules\Report\Http\Services;


use Modules\Country\Entities\City;
use Modules\Country\Entities\Country;
use Modules\Country\Entities\State;
use Modules\Login\Entities\User;
use Modules\Category\Entities\Category;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Order\Entities\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Modules\Product\Entities\Product;

class ReportService
{
    /**
     * Show All Brand With Orders
     *
     * @param $request
     * @return array
     */
    public function saleData($request): array
    {

        $brands = User::where('role', '=', ROLE::ROLE_BRAND)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('brands');
            })->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->with('profile', 'orders.brand');
        $fromDate = Carbon::parse($request->input('from_date'));
        $toDate = Carbon::parse($request->input('to_date'));
        $brand_name = $request->input('custom_filter');
        if (!empty($request->input('from_date')) && !empty($request->input('to_date'))) {
            $brands->whereHas('orders', function ($query) use ($fromDate, $toDate) {

                $query->whereBetween('created_at', [$fromDate, $toDate]);
            });
        }
        if (!empty($request->input('custom_filter'))) {
            $brands->whereHas('profile', function ($query) use ($brand_name) {

                $query->where('brand_name', 'LIKE', '%' . $brand_name . '%');
            });
        }
        $filteredCount = $brands->count();
        $start = $request->start ?? 0;
        $length = $request->length ?? 0;
        $brands = $brands->offset($start)->limit($length);
        $result = DataTables::of($brands)
            ->addIndexColumn()
            ->addColumn('brand_name', function ($row) {
                return $row->profile->brand_name;
            })
            ->addColumn('orders_sum_total_amount', function ($row) {
                if (!empty($row->orders_sum_total_amount)) {
                    return '$' . number_format($row->orders_sum_total_amount, 2);
                } else {
                    return '$0.00';
                }

            })
            ->addColumn('phone_number', function ($row) {
                return '+' . $row->profile->country_code . '' . $row->profile->phone_number;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . url('/brand/details/' . $row->id) . '"><span class="fas fa-eye"></span></a> <a href="' . url('/product/' . $row->id) . '"><span class="fas fa-list"></span></a>  <a href="' . url('/order/brand-order/' . $row->id) . '"><span class="fas fa-file-invoice-dollar"></span></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;
    }

    /**
     * Show All Brand With Orders
     *
     * @param $request
     * @return array
     */
    public function saleChart($request): array
    {

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $brand_name = $request->input('custom_filter');
        $sales = Order::orderBy('created_at');
        $sales = $sales->with('brand');
        if (!empty($fromDate) && !empty($toDate)) {
            $sales->whereBetween('created_at', [$fromDate, $toDate]);
        };
        if (!empty($request->input('custom_filter'))) {
            $sales->whereHas('brand', function ($query) use ($brand_name) {

                $query->where('brand_name', 'LIKE', '%' . $brand_name . '%');
            });
        }
        $sales = $sales->get();

        $chartData = [];

        foreach ($sales as $sale) {
            $year = date('Y', strtotime($sale->created_at));
            $month = date('F', strtotime($sale->created_at));

            if (!isset($chartData[$year])) {
                $chartData[$year] = [];
            }
            if (!isset($chartData[$year][$month])) {
                $chartData[$year][$month] = 0;
            }
            $chartData[$year][$month] += $sale->total_amount;
        }

        $chartLabels = [];
        $chartSeries = [];

        foreach ($chartData as $year => $data) {
            $chartLabels[] = $year;
            $seriesData = [];
            foreach ($data as $month => $amount) {
                $seriesData[] = $amount;
            }

            $chartSeries[] = [
                'name' => $year,
                'data' => $seriesData
            ];
        }
        $totals = [];
        foreach ($chartData as $year => $data) {
            $totals[$year] = [];
            foreach ($data as $month => $amount) {
                if (!isset($totals[$year][$month])) {
                    $totals[$year][$month] = 0;
                }
                $totals[$year][$month] += $amount;
            }
        }


        return ['res' => true, 'labels' => $chartLabels, 'series' => $chartSeries, 'totals' => $totals];
    }

    /**
     * Export Brand By params
     *
     * @param $request
     * @return string
     */
    public function exportBrand($request): string
    {

        $filename = 'data.csv';
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $brand_name = $request->input('custom_filter');
        $brands = User::where('role', '=', ROLE::ROLE_BRAND)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('brands');
            })->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->with('profile', 'orders.brand');
        if (!empty($request->input('from_date')) && !empty($request->input('to_date'))) {
            $brands->whereHas('orders', function ($query) use ($fromDate, $toDate) {

                $query->whereBetween('created_at', [$fromDate, $toDate]);
            });
        }
        if (!empty($request->input('custom_filter'))) {
            $brands->whereHas('profile', function ($query) use ($brand_name) {

                $query->where('brand_name', 'LIKE', '%' . $brand_name . '%');
            });
        }
        $brands = $brands->get();
        $filepath = storage_path('exports/' . $filename);
        $csvData = "Name,Email,Brand,Total Order,Total Amount,Phone Number\n";
        foreach ($brands as $brand) {
            $csvData .= "{$brand->first_name} {$brand->last_name},{$brand->email},{$brand->profile->brand_name},{$brand->orders_count},{$brand->orders_sum_total_amount},{+}{$brand->profile->country_code}{$brand->profile->phone_number}\n";
        }
        file_put_contents($filepath, $csvData);
        return url('/storage/exports/data.csv');
    }

    /**
     * Show All Brand
     *
     * @param $request
     * @return array
     */
    public function brandRegData($request): array
    {
        $catID = $request->catID;
        $country = $request->countrySelect;
        $state = $request->stateSelect;
        $city = $request->citySelect;
        $established_year = $request->established_year;
        $brands = User::where('role', '=', ROLE::ROLE_BRAND)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('brands');
            })
            ->with('profile');
        if (!empty($country)) {
            $brands->whereHas('profile', function ($query) use ($country) {

                $query->where('headquatered', $country);
            });
        }
        if (!empty($state)) {
            $brands->whereHas('profile', function ($query) use ($state) {
                $query->where('state', $state);
            });
        }

        if (!empty($city)) {
            $brands->whereHas('profile', function ($query) use ($city) {

                $query->where('city', $city);
            });
        }
        if (!empty($catID)) {
            $brands->whereHas('profile', function ($query) use ($catID) {
                $query->where('prime_cat', $catID);
            });
        }
        if (!empty($established_year)) {
            $brands->whereHas('profile', function ($query) use ($established_year) {

                $query->where('established_year', $established_year);
            });
        }
        $filteredCount = $brands->count();
        $start = $request->start ?? 0;
        $length = $request->length ?? 0;
        $brands = $brands->offset($start)->limit($length);
        $result = DataTables::of($brands)
            ->addIndexColumn()
            ->addColumn('brand_name', function ($row) {
                return $row->profile->brand_name;
            })
            ->addColumn('headquatered', function ($row) {
                $countryName = '';
                if (!empty($row->profile->city)) {
                    $city = City::find($row->profile->city);
                    $countryName = $city->state->country->name;
                }
                return $countryName;
            })
            ->addColumn('state', function ($row) {
                $stateName = '';
                if (!empty($row->profile->city)) {
                    $city = City::find($row->profile->city);
                    $stateName = $city->state->name;
                }
                return $stateName;
            })
            ->addColumn('city', function ($row) {
                $cityName = '';
                if (!empty($row->profile->city)) {
                    $city = City::find($row->profile->city);
                    $cityName = $city->name;
                }
                return $cityName;

            })
            ->addColumn('prime_cat', function ($row) {
                $categoryName = '';
                $category = Category::find($row->profile->prime_cat);
                if (!empty($category)) {
                    $categoryName = $category->title;
                }
                return $categoryName;
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })

            ->addColumn('established_year', function ($row) {
                return $row->profile->established_year;
            })
            ->addColumn('phone_number', function ($row) {
                return '+' . $row->profile->country_code . '' . $row->profile->phone_number;
            })
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;
    }

    /**
     * Export Brand Reg By params
     *
     * @param $request
     * @return string
     */
    public function exportBrandReg($request): string
    {

        $filename = 'data.csv';
        $catID = $request->catID;
        $country = $request->countrySelect;
        $state = $request->stateSelect;
        $city = $request->citySelect;
        $established_year = $request->established_year;
        $brands = User::where('role', '=', ROLE::ROLE_BRAND)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('brands');
            })
            ->with('profile');
        if (!empty($country)) {
            $brands->whereHas('profile', function ($query) use ($country) {

                $query->where('headquatered', $country);
            });
        }
        if (!empty($state)) {
            $brands->whereHas('profile', function ($query) use ($state) {
                $query->where('state', $state);
            });
        }

        if (!empty($city)) {
            $brands->whereHas('profile', function ($query) use ($city) {

                $query->where('city', $city);
            });
        }
        if (!empty($catID)) {
            $brands->whereHas('profile', function ($query) use ($catID) {
                $query->where('prime_cat', $catID);
            });
        }
        if (!empty($established_year)) {
            $brands->whereHas('profile', function ($query) use ($established_year) {

                $query->where('established_year', $established_year);
            });
        }
        $brands = $brands->get();
        $filepath = storage_path('exports/' . $filename);
        $csvData = "Name,Email,Brand,Registered Date,Country,State,City,Primary Category,Established Year, Phone Number\n";
        foreach ($brands as $brand) {
            $reg_date = Carbon::parse($brand->created_at)->format('Y-m-d');
            $cityName = '';
            $stateName = '';
            $countryName ='';
            $city = City::find($brand->profile->city);
            if(!empty($city))
            {
                $state = $city->state;
                $cityName = $city->name;
                $stateName = $city->state->name;
                $countryName = $state->country->name;
            }

            $categoryName = '';
            $category = Category::find($brand->profile->prime_cat);
            if (!empty($category)) {
                $categoryName = $category->title;
            }
            $csvData .= "{$brand->first_name} {$brand->last_name},{$brand->email},{$brand->profile->brand_name},{$reg_date},{$countryName},{$stateName},{$cityName},{$categoryName},{$brand->profile->established_year},{+}{$brand->profile->country_code}{$brand->profile->phone_number}\n";
        }
        file_put_contents($filepath, $csvData);
        return url('/storage/exports/data.csv');
    }

    /**
     * Show All Retailer
     *
     * @param $request
     * @return array
     */
    public function retailerRegData($request): array
    {
        $catID = $request->catID;
        $country = $request->countrySelect;
        $state = $request->stateSelect;
        $city = $request->citySelect;
        $retailers = User::where('role', '=', ROLE::ROLE_RETAILER)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('retailers');
            })
            ->with('retailer');
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
            $retailers->whereHas('retailer', function ($query) use ($catID) {
                $query->whereRaw("FIND_IN_SET(?, store_cats)", [$catID]);
            });
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
            ->addColumn('country', function ($row) {
                $countryName = '';
                if (!empty($row->retailer->country)) {
                    $country = Country::find($row->retailer->country);
                    $countryName = $country->name;
                }
                return $countryName;
            })
            ->addColumn('state', function ($row) {
                $stateName = '';
                if (!empty($row->retailer->state)) {
                    $state = State::find($row->retailer->state);
                    $stateName = $state->name;
                }
                return $stateName;
            })
            ->addColumn('city', function ($row) {
                $cityName = '';
                if (!empty($row->retailer->town)) {
                    $city = City::find($row->retailer->town);
                    $cityName = $city->name;
                }
                return $cityName;

            })
            ->addColumn('prime_cat', function ($row) {

                $foreignIdArray = explode(',', $row->retailer->store_cats);
                $relatedItems = Category::whereIn('id', $foreignIdArray)->get();
                $names = $relatedItems->pluck('title')->toArray();
                return implode(',', $names);
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })


            ->addColumn('phone_number', function ($row) {
                return '+' . $row->retailer->country_code . $row->retailer->phone_number;
            })
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;
    }


    /**
     * Export Retailer Reg By params
     *
     * @param $request
     * @return string
     */
    public function exportRetailerReg($request): string
    {

        $filename = 'data.csv';
        $catID = $request->catID;
        $country = $request->countrySelect;
        $state = $request->stateSelect;
        $city = $request->citySelect;
        $retailers = User::where('role', '=', ROLE::ROLE_RETAILER)
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('retailers');
            })
            ->with('retailer');
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
            $retailers->whereHas('retailer', function ($query) use ($catID) {
                $query->whereRaw("FIND_IN_SET(?, store_cats)", [$catID]);
            });
        }
        $retailers = $retailers->get();
        $filepath = storage_path('exports/' . $filename);
        $csvData = "Name,Email,Store,Registered Date,Country,State,City,Primary Category,Phone Number\n";
        foreach ($retailers as $retailer) {
            $reg_date = Carbon::parse($retailer->created_at)->format('Y-m-d');
            $cityName = '';
            $stateName = '';
            $countryName ='';
            $city = City::find($retailer->retailer->town);
            if(!empty($city))
            {
                $state = $city->state;
                $cityName = $city->name;
                $stateName = $city->state->name;
                $countryName = $state->country->name;
            }

            $foreignIdArray = explode(',', $retailer->retailer->store_cats);
            $relatedItems = Category::whereIn('id', $foreignIdArray)->get();
            $names = $relatedItems->pluck('title')->toArray();
            $category =  implode('-', $names);

            $csvData .= "{$retailer->first_name} {$retailer->last_name},{$retailer->email},{$retailer->store_name},{$retailer->retailer->store_name},{$reg_date},{$countryName},{$stateName},{$cityName},{$category},{+}{$retailer->retailer->country_code}{$retailer->retailer->phone_number}\n";
        }
        file_put_contents($filepath, $csvData);
        return url('/storage/exports/data.csv');
    }

    /**
     * Show All Products
     *
     * @param $request
     * @return array
     */
    public function productData($request): array
    {

        $data = Product::where('products.status', '=', PRODUCT::PRODUCT_PUBLISHED)->withCount('variations')
            ->withSum('variations', 'stock')->orderBy('updated_at', 'desc');
        $filteredCount = $data->count();
        $start = $request->start ?? 0;
        $length = $request->length ?? 0;
        $data = $data->offset($start)->limit($length);
        $result = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('stock', function ($row) {
                return $row->variations_sum_variation_stock ?? $row->stock;
            })
            ->make(true);
        $resultData = $result->getData(true);
        $resultData['recordsFiltered'] = $filteredCount;
        $resultData['draw'] = $request->draw;

        return $resultData;

    }

    /**
     * Export Product Stock
     *
     * @param $request
     * @return string
     */
    public function exportProduct($request): string
    {

        $filename = 'data.csv';

        $products = Product::where('products.status', '=', PRODUCT::PRODUCT_PUBLISHED)->withCount('variations')
            ->withSum('variations', 'stock')->orderBy('updated_at', 'desc');

        $products = $products->get();
        $filepath = storage_path('exports/' . $filename);
        $csvData = "Name,SKU,Options,Stock\n";
        foreach ($products as $product) {

            $stock = $product->variations_sum_variation_stock ?? $product->stock;
            $csvData .= "{$product->name},{$product->sku},{$product->variations_count},{$stock}\n";
        }
        file_put_contents($filepath, $csvData);
        return url('/storage/exports/data.csv');
    }

}
