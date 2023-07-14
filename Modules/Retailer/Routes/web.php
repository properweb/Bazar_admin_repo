<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::middleware(['auth', 'permission:manage retailers'])
    ->prefix('retailer')
    ->name('retailer.')
    ->group(function () {
        Route::get('/show-retailer', 'RetailerController@index');
        Route::get('/retailer-data', 'RetailerController@retailerData');
        Route::get('/details/{id}', 'RetailerController@details');
        Route::get('/delete/{id}', 'RetailerController@delete');
        Route::get('/change-status/{id}/{active}', 'RetailerController@changeStatus');
        Route::get('/create', 'RetailerController@create');
        Route::post('/create', 'RetailerController@createRetailer');
    });

