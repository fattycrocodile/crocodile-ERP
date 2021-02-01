<?php

use Illuminate\Support\Facades\Route;

Route::get('config', 'ConfigController@welcome');


Route::group(['middleware' => ['auth:web']], function () {
    Route::group(['prefix' => 'config'], function () {
        Route::get('/settings', 'SettingController@index')->name('admin.settings');
        Route::post('/settings', 'SettingController@update')->name('admin.settings.update');
    });

    Route::group(['prefix' => 'config/lookups'], function () {
        Route::get('/', 'LookupController@index')->name('config.lookups.index');
        Route::get('/create', 'LookupController@create')->name('config.lookups.create');
        Route::post('/store', 'LookupController@store')->name('config.lookups.store');
        Route::get('/{id}/edit', 'LookupController@edit')->name('config.lookups.edit');
        Route::post('/{id}/update', 'LookupController@update')->name('config.lookups.update');
        Route::delete('/{id}/delete', 'LookupController@delete')->name('config.lookups.delete');
    });
});
