<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')
    ->prefix('role')
    ->name('role.')
    ->group(function () {

        Route::get('/create', 'RoleController@create');
        Route::post('/create', 'RoleController@submitRole');
        Route::get('/show', 'RoleController@show');
        Route::get('/details/{id}', 'RoleController@details');
        Route::post('/details/{id}', 'RoleController@update');
        Route::get('/delete/{id}', 'RoleController@delete');
        Route::post('/delete-multiple', 'RoleController@deleteMultiple');
        Route::get('/show-admin-user', 'RoleController@showAdmin');
        Route::get('/create-user', 'RoleController@createUser');
        Route::post('/create-user', 'RoleController@postUser');
        Route::get('/user-details/{id}', 'RoleController@detailUser');
        Route::post('/user-details/{id}', 'RoleController@updateUser');
        Route::get('/user-delete/{id}', 'RoleController@deleteUser');
    });

