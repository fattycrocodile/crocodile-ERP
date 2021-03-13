<?php

use Illuminate\Support\Facades\Route;

Route::get('commercial', 'CommercialController@welcome');

Route::group(['middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'commercial/suppliers'], function () {
        Route::get('/', 'SuppliersController@index')->name('commercial.suppliers.index');
        Route::get('/create', 'SuppliersController@create')->name('commercial.suppliers.create');
        Route::post('/store', 'SuppliersController@store')->name('commercial.suppliers.store');
        Route::get('/{id}/edit', 'SuppliersController@edit')->name('commercial.suppliers.edit');
        Route::post('/{id}/update', 'SuppliersController@update')->name('commercial.suppliers.update');
        Route::delete('/{id}/delete', 'SuppliersController@delete')->name('commercial.suppliers.delete');
    });

    Route::group(['prefix' => 'commercial/purchase'], function () {
        Route::get('/', 'PurchaseController@index')->name('commercial.purchase.index');
        Route::get('/create', 'PurchaseController@create')->name('commercial.purchase.create');
        Route::post('/store', 'PurchaseController@store')->name('commercial.purchase.store');
        Route::get('/{id}/edit', 'PurchaseController@edit')->name('commercial.purchase.edit');
        Route::post('/{id}/update', 'PurchaseController@update')->name('commercial.purchase.update');
        Route::delete('/{id}/delete', 'PurchaseController@delete')->name('commercial.purchase.delete');
        Route::get('/{id}/voucher', 'PurchaseController@voucher')->name('commercial.purchase.voucher');
    });

    Route::group(['prefix' => 'commercial/reports'], function () {
        Route::get('/purchase_report', 'PurchaseController@purchaseReport')->name('commercial.reports.purchase');
        Route::post('/purchase_report_view', 'PurchaseController@purchaseReportView')->name('commercial.reports.purchase-view');
    });
});
