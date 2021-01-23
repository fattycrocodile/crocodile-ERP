<?php
use Illuminate\Support\Facades\Route;
Route::get('store-inventory', 'StoreInventoryController@welcome');


Route::group(['middleware' => ['auth:web']], function () {

    Route::get('/settings', 'SettingController@index')->name('admin.settings');
    Route::post('/settings', 'SettingController@update')->name('admin.settings.update');

    Route::group(['prefix' => 'config/categories'], function () {
        Route::get('/', 'CategoryController@index')->name('admin.categories.index');
        Route::get('/create', 'CategoryController@create')->name('admin.categories.create');
        Route::post('/store', 'CategoryController@store')->name('admin.categories.store');
        Route::get('/{id}/edit', 'CategoryController@edit')->name('admin.categories.edit');
        Route::post('/update', 'CategoryController@update')->name('admin.categories.update');
        Route::get('/{id}/delete', 'CategoryController@delete')->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'config/brand'], function () {
        Route::get('/', 'BrandController@index')->name('admin.brands.index');
        Route::get('/create', 'BrandController@create')->name('admin.brands.create');
        Route::post('/store', 'BrandController@store')->name('admin.brands.store');
        Route::get('/{id}/edit', 'BrandController@edit')->name('admin.brands.edit');
        Route::post('/update', 'BrandController@update')->name('admin.brands.update');
        Route::get('/{id}/delete', 'BrandController@delete')->name('admin.brands.delete');
    });
});
