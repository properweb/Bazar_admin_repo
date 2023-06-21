<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')
    ->prefix('brand')
    ->name('brand.')
    ->group(function () {

        Route::get('/', 'BrandController@index');

    });

