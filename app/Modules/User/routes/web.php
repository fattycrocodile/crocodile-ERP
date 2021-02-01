<?php
use Illuminate\Support\Facades\Route;
Route::get('users', 'usersController@welcome');

Route::group(['middleware' => ['auth:web']], function () {
    Route::group(['prefix' => 'users/permissions'], function () {
        Route::get('/', 'PermissionsController@index')->name('users.permissions.index');
        Route::get('/create', 'PermissionsController@create')->name('users.permissions.create');
        Route::post('/store', 'PermissionsController@store')->name('users.permissions.store');
        Route::get('/{id}/edit', 'PermissionsController@edit')->name('users.permissions.edit');
        Route::post('/{id}//update', 'PermissionsController@update')->name('users.permissions.update');
        Route::delete('/{id}/delete', 'PermissionsController@delete')->name('users.permissions.delete');
    });

    Route::group(['prefix' => 'users/roles'], function () {
        Route::get('/', 'RolesController@index')->name('users.roles.index');
        Route::get('/create', 'RolesController@create')->name('users.roles.create');
        Route::post('/store', 'RolesController@store')->name('users.roles.store');
        Route::get('/{id}/edit', 'RolesController@edit')->name('users.roles.edit');
        Route::post('/{id}//update', 'RolesController@update')->name('users.roles.update');
        Route::delete('/{id}/delete', 'RolesController@delete')->name('users.roles.delete');
    });

    Route::group(['prefix' => 'users/admins'], function () {
        Route::get('/', 'AdminsController@index')->name('users.admins.index');
        Route::get('/create', 'AdminsController@create')->name('users.admins.create');
        Route::post('/store', 'AdminsController@store')->name('users.admins.store');
        Route::get('/{id}/edit', 'AdminsController@edit')->name('users.admins.edit');
        Route::post('/{id}//update', 'AdminsController@update')->name('users.admins.update');
        Route::delete('/{id}/delete', 'AdminsController@delete')->name('users.admins.delete');
    });

});
