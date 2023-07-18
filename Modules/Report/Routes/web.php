<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::middleware(['auth', 'permission:manage reports'])
    ->prefix('report')
    ->name('report.')
    ->group(function () {
        Route::get('/sale-report', 'ReportController@sale');
        Route::get('/sale-data', 'ReportController@saleData');
        Route::get('/sale-chart', 'ReportController@saleChart');
        Route::get('/export-brand', 'ReportController@exportBrand');
        Route::get('/brand-reg-report', 'ReportController@brandReg');
        Route::get('/brand-reg-data', 'ReportController@brandRegData');
        Route::get('/export-brand-reg', 'ReportController@exportBrandReg');
        Route::get('/retailer-reg-report', 'ReportController@retailerReg');
        Route::get('/retailer-reg-data', 'ReportController@retailerRegData');
        Route::get('/export-retailer-reg', 'ReportController@exportRetailerReg');
        Route::get('/product-report', 'ReportController@productReport');
        Route::get('/product-data', 'ReportController@productData');
        Route::get('/export-product', 'ReportController@exportProduct');
    });

