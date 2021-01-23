<?php

use Illuminate\Support\Facades\Route;

Route::get('config', 'ConfigController@welcome');


Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/settings', 'SettingController@index')->name('admin.settings');
    Route::post('/settings', 'SettingController@update')->name('admin.settings.update');

});
