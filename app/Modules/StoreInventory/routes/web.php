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

    Route::group(['prefix' => 'store-inventory/stores'], function () {
        Route::get('/', 'StoresController@index')->name('storeInventory.stores.index');
        Route::get('/create', 'StoresController@create')->name('storeInventory.stores.create');
        Route::post('/store', 'StoresController@store')->name('storeInventory.stores.store');
        Route::get('/{id}/edit', 'StoresController@edit')->name('storeInventory.stores.edit');
        Route::post('/{id}/update', 'StoresController@update')->name('storeInventory.stores.update');
        Route::delete('/{id}/delete', 'StoresController@delete')->name('storeInventory.stores.delete');
    });

    Route::group(['prefix' => 'store-inventory/purchase-return'], function () {
        Route::get('/', 'PurchaseReturnController@index')->name('storeInventory.pr.index');
        Route::get('/create', 'PurchaseReturnController@create')->name('storeInventory.pr.create');
        Route::post('/store', 'PurchaseReturnController@store')->name('storeInventory.pr.store');
        Route::get('/{id}/edit', 'PurchaseReturnController@edit')->name('storeInventory.pr.edit');
        Route::post('/{id}/update', 'PurchaseReturnController@update')->name('storeInventory.pr.update');
        Route::post('/voucher', 'PurchaseReturnController@voucher')->name('storeInventory.pr.voucher');
        Route::delete('/{id}/delete', 'PurchaseReturnController@delete')->name('storeInventory.pr.delete');
    });

    Route::group(['prefix' => 'store-inventory/store-transfer'], function () {
        Route::get('/', 'StoreTransferController@index')->name('storeInventory.st.index');
        Route::get('/create', 'StoreTransferController@create')->name('storeInventory.st.create');
        Route::post('/store', 'StoreTransferController@store')->name('storeInventory.st.store');
        Route::get('/{id}/edit', 'StoreTransferController@edit')->name('storeInventory.st.edit');
        Route::post('/{id}/update', 'StoreTransferController@update')->name('storeInventory.st.update');
        Route::post('/receive', 'StoreTransferController@receive')->name('storeInventory.st.receive');
        Route::post('/voucher', 'StoreTransferController@voucher')->name('storeInventory.st.voucher');
        Route::delete('/{id}/delete', 'StoreTransferController@delete')->name('storeInventory.st.delete');
    });

    Route::group(['prefix' => 'store-inventory/purchase-receive'], function () {
        Route::get('/', 'PurchaseReturnController@index')->name('storeInventory.prec.index');
        Route::get('/create', 'PurchaseReturnController@create')->name('storeInventory.prec.create');
        Route::post('/store', 'PurchaseReturnController@store')->name('storeInventory.prec.store');
        Route::get('/{id}/edit', 'PurchaseReturnController@edit')->name('storeInventory.prec.edit');
        Route::post('/{id}/update', 'PurchaseReturnController@update')->name('storeInventory.prec.update');
        Route::post('/voucher', 'PurchaseReturnController@voucher')->name('storeInventory.prec.voucher');
        Route::delete('/{id}/delete', 'PurchaseReturnController@delete')->name('storeInventory.prec.delete');
    });

    Route::group(['prefix' => 'store-inventory/inventory'], function () {
        Route::get('/', 'InventoryController@index')->name('storeInventory.inventory.index');
//        Route::get('/create', 'InventoryController@create')->name('storeInventory.inventory.create');
//        Route::post('/store', 'InventoryController@store')->name('storeInventory.inventory.store');
//        Route::get('/{id}/edit', 'InventoryController@edit')->name('storeInventory.inventory.edit');
//        Route::post('/{id}/update', 'InventoryController@update')->name('storeInventory.inventory.update');
//        Route::delete('/{id}/delete', 'InventoryController@delete')->name('storeInventory.inventory.delete');
    });

    Route::group(['prefix' => 'inventory/reports'], function () {
        Route::get('/stock_report', 'InventoryController@stockReport')->name('storeInventory.reports.stock-report');
        Route::post('/stock_report_view', 'InventoryController@stockReportView')->name('storeInventory.reports.stock-report-view');

        Route::get('/stock_value_report', 'InventoryController@stockValueReport')->name('storeInventory.reports.stock-value-report');
        Route::post('/stock_value_report_view', 'InventoryController@stockValueReportView')->name('storeInventory.reports.stock-value-report-view');

        Route::get('/stock_ledger_report', 'InventoryController@stockLedgerReport')->name('storeInventory.reports.stock-ledger-report');
        Route::post('/stock_ledger_report_view', 'InventoryController@stockLedgerReportView')->name('storeInventory.reports.stock-ledger-report-view');

        Route::get('/purchase_return_report', 'PurchaseReturnController@purchaseReturnReport')->name('storeInventory.reports.purchase-return-report');
        Route::post('/purchase_return_report_view', 'PurchaseReturnController@purchaseReturnReportView')->name('storeInventory.reports.purchase-return-report-view');

        Route::get('/product-wise-purchase_return_report', 'PurchaseReturnController@productWisePurchaseReturnReport')->name('storeInventory.reports.product-wise-purchase-return-report');
        Route::post('/product-wise-purchase_return_report_view', 'PurchaseReturnController@productWisePurchaseReturnReportView')->name('storeInventory.reports.product-wise-purchase-return-report-view');

    });
});
