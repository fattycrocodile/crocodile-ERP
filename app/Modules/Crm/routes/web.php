<?php
use Illuminate\Support\Facades\Route;

Route::get('crm', 'CrmController@welcome');

Route::group(['middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'crm/customers'], function () {
        Route::get('/', 'CustomersController@index')->name('crm.customers.index');
        Route::get('/create', 'CustomersController@create')->name('crm.customers.create');
        Route::post('/store', 'CustomersController@store')->name('crm.customers.store');
        Route::get('/{id}/edit', 'CustomersController@edit')->name('crm.customers.edit');
        Route::post('/{id}/update', 'CustomersController@update')->name('crm.customers.update');
        Route::delete('/{id}/delete', 'CustomersController@delete')->name('crm.customers.delete');
    });

    Route::group(['prefix' => 'crm/sales/order'], function () {
        Route::get('/', 'SellOrderController@index')->name('crm.sales.order.index');
        Route::get('/create', 'SellOrderController@create')->name('crm.sales.order.create');
        Route::post('/store', 'SellOrderController@store')->name('crm.sales.order.store');
        Route::get('/{id}/edit', 'SellOrderController@edit')->name('crm.sales.order.edit');
        Route::post('/{id}/update', 'SellOrderController@update')->name('crm.sales.order.update');
        Route::delete('/{id}/delete', 'SellOrderController@delete')->name('crm.sales.order.delete');
        Route::get('/{id}/voucher', 'SellOrderController@voucher')->name('crm.sales.order.voucher');
    });

    Route::group(['prefix' => 'crm/sales'], function () {
        Route::get('/', 'InvoiceController@index')->name('crm.invoice.index');
        Route::get('/create', 'InvoiceController@create')->name('crm.invoice.create');
        Route::post('/store', 'InvoiceController@store')->name('crm.invoice.store');
        Route::get('/{id}/edit', 'InvoiceController@edit')->name('crm.invoice.edit');
        Route::post('/{id}/update', 'InvoiceController@update')->name('crm.invoice.update');
        Route::delete('/{id}/delete', 'InvoiceController@delete')->name('crm.invoice.delete');
        Route::get('/{id}/voucher', 'InvoiceController@voucher')->name('crm.invoice.voucher');
    });
});
