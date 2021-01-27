<?php
use Illuminate\Support\Facades\Route;
Route::get('store-inventory', 'StoreInventoryController@welcome');


Route::group(['middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'store-inventory/categories'], function () {
        Route::get('/', 'CategoryController@index')->name('storeInventory.categories.index');
        Route::get('/create', 'CategoryController@create')->name('storeInventory.categories.create');
        Route::post('/store', 'CategoryController@store')->name('storeInventory.categories.store');
        Route::get('/{id}/edit', 'CategoryController@edit')->name('storeInventory.categories.edit');
        Route::post('/{id}/update', 'CategoryController@update')->name('storeInventory.categories.update');
        Route::delete('/{id}/delete', 'CategoryController@delete')->name('storeInventory.categories.delete');
    });

    Route::group(['prefix' => 'store-inventory/units'], function () {
        Route::get('/', 'UnitController@index')->name('storeInventory.units.index');
        Route::get('/create', 'UnitController@create')->name('storeInventory.units.create');
        Route::post('/store', 'UnitController@store')->name('storeInventory.units.store');
        Route::get('/{id}/edit', 'UnitController@edit')->name('storeInventory.units.edit');
        Route::post('/{id}/update', 'UnitController@update')->name('storeInventory.units.update');
        Route::delete('/{id}/delete', 'UnitController@delete')->name('storeInventory.units.delete');
    });

    Route::group(['prefix' => 'store-inventory/brand'], function () {
        Route::get('/', 'BrandController@index')->name('storeInventory.brands.index');
        Route::get('/create', 'BrandController@create')->name('storeInventory.brands.create');
        Route::post('/store', 'BrandController@store')->name('storeInventory.brands.store');
        Route::get('/{id}/edit', 'BrandController@edit')->name('storeInventory.brands.edit');
        Route::post('/update', 'BrandController@update')->name('storeInventory.brands.update');
        Route::delete('/{id}/delete', 'BrandController@delete')->name('storeInventory.brands.delete');
    });

    Route::group(['prefix' => 'store-inventory/products'], function () {
        Route::get('/', 'ProductController@index')->name('storeInventory.products.index');
        Route::get('/create', 'ProductController@create')->name('storeInventory.products.create');
        Route::post('/store', 'ProductController@store')->name('storeInventory.products.store');
        Route::get('/{id}/edit', 'ProductController@edit')->name('storeInventory.products.edit');
        Route::post('/{id}/update', 'ProductController@update')->name('storeInventory.products.update');
        Route::delete('/{id}/delete', 'ProductController@delete')->name('storeInventory.products.delete');
    });

    Route::group(['prefix' => 'store-inventory/sellprices'], function () {
        Route::get('/', 'SellPriceController@index')->name('storeInventory.sellprices.index');
        Route::get('/create', 'SellPriceController@create')->name('storeInventory.sellprices.create');
        Route::post('/store', 'SellPriceController@store')->name('storeInventory.sellprices.store');
        Route::get('/{id}/edit', 'SellPriceController@edit')->name('storeInventory.sellprices.edit');
        Route::post('/{id}/update', 'SellPriceController@update')->name('storeInventory.sellprices.update');
        Route::delete('/{id}/delete', 'SellPriceController@delete')->name('storeInventory.sellprices.delete');
    });
});
