<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::middleware(['auth', 'permission:manage brands'])
    ->prefix('brand')
    ->name('brand.')
    ->group(function () {
        Route::get('/show-brand', 'BrandController@index');
        Route::get('/create', 'BrandController@create');
        Route::post('/create', 'BrandController@createBrand');
        Route::get('/brand-data', 'BrandController@brandData');
        Route::get('/details/{id}', 'BrandController@details');
        Route::get('/delete/{id}', 'BrandController@delete');
        Route::get('/trash', 'BrandController@trash');
        Route::get('/states/{countryId}', 'BrandController@getState');
        Route::get('/cities/{stateId}', 'BrandController@getCity');
        Route::get('/live/{id}', 'BrandController@live');
    });

