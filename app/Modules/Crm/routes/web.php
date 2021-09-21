<?php

use Illuminate\Support\Facades\Route;

Route::get('crm', 'CrmController@welcome');

Route::group(['middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'crm/customers'], function () {
        Route::get('/', 'CustomersController@index')->name('crm.customers.index');
        Route::get('/create', 'CustomersController@create')->name('crm.customers.create');
        Route::post('/store', 'CustomersController@store')->name('crm.customers.store');
        Route::post('/ajaxStore', 'CustomersController@ajaxStore')->name('crm.customers.ajaxStore');
        Route::get('/{id}/edit', 'CustomersController@edit')->name('crm.customers.edit');
        Route::post('/{id}/update', 'CustomersController@update')->name('crm.customers.update');
        Route::delete('/{id}/delete', 'CustomersController@delete')->name('crm.customers.delete');
        Route::post('/due-invoice-list', 'InvoiceController@getDueInvoiceJsonList')->name('crm.customers.dueInvoiceJson');
    });

    Route::group(['prefix' => 'crm/sales/order'], function () {
        Route::get('/', 'SellOrderController@index')->name('crm.sales.order.index');
        Route::get('/create', 'SellOrderController@create')->name('crm.sales.order.create');
        Route::post('/store', 'SellOrderController@store')->name('crm.sales.order.store');
        Route::get('/{id}/edit', 'SellOrderController@edit')->name('crm.sales.order.edit');
        Route::get('/{id}/invoice-create', 'SellOrderController@invoiceCreate')->name('crm.sales.order.invoice.create');
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

    Route::group(['prefix' => 'crm/sales-return'], function () {
        Route::get('/', 'InvoiceReturnController@index')->name('crm.invoiceReturn.index');
        Route::get('/create', 'InvoiceReturnController@create')->name('crm.invoiceReturn.create');
        Route::post('/store', 'InvoiceReturnController@store')->name('crm.invoiceReturn.store');
        Route::get('/{id}/edit', 'InvoiceReturnController@edit')->name('crm.invoiceReturn.edit');
        Route::post('/{id}/update', 'InvoiceReturnController@update')->name('crm.invoiceReturn.update');
        Route::post('/voucher', 'InvoiceReturnController@voucher')->name('crm.invoiceReturn.voucher');
        Route::delete('/{id}/delete', 'InvoiceReturnController@delete')->name('crm.invoiceReturn.delete');
    });

    Route::group(['prefix' => 'crm/reports'], function () {
        Route::get('/order_report', 'SellOrderController@orderReport')->name('crm.reports.order-report');
        Route::post('/order_report_view', 'SellOrderController@orderReportView')->name('crm.reports.order-report-view');

        Route::get('/invoice_report', 'InvoiceController@invoiceReport')->name('crm.reports.invoice-report');
        Route::post('/invoice_report_view', 'InvoiceController@invoiceReportView')->name('crm.reports.invoice-report-view');

        Route::get('/customer_sales_report', 'InvoiceController@customerSalesReport')->name('crm.reports.customer-sales-report');
        Route::post('/customer_sales_report_view', 'InvoiceController@customerSalesReportView')->name('crm.reports.customer-sales-report-view');

        Route::get('/invoice_return_report', 'InvoiceReturnController@invoiceReturnReport')->name('crm.reports.invoice-return-report');
        Route::post('/invoice_return_report_view', 'InvoiceReturnController@invoiceReturnReportView')->name('crm.reports.invoice-return-report-view');

        Route::get('/customer_return_report', 'InvoiceReturnController@customerReturnReport')->name('crm.reports.customer-return-report');
        Route::post('/customer_return_report_view', 'InvoiceReturnController@customerReturnReportView')->name('crm.reports.customer-return-report-view');

        Route::get('/customer_due_report', 'CustomersController@customerDueReport')->name('crm.reports.due-report');
        Route::post('/customer_due_report_view', 'CustomersController@customerDueReportView')->name('crm.reports.due-report-view');

        Route::get('/product_wise_sales_report', 'InvoiceController@productWiseSalesReport')->name('crm.reports.product-wise-sales');
        Route::post('/product_wise_sales_report_view', 'InvoiceController@productWiseSalesReportView')->name('crm.reports.product-wise-sales-view');
    });
});
