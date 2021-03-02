<?php
use Illuminate\Support\Facades\Route;
Route::get('accounting', 'AccountingController@welcome');


Route::group(['middleware' => ['auth:web']], function () {
    Route::group(['prefix' => 'accounting/chartofaccounts'], function () {
        Route::get('/', 'ChartOfAccountsController@index')->name('accounting.chartofaccounts.index');
        Route::get('/create', 'ChartOfAccountsController@create')->name('accounting.chartofaccounts.create');
        Route::post('/store', 'ChartOfAccountsController@store')->name('accounting.chartofaccounts.store');
        Route::get('/{id}/edit', 'ChartOfAccountsController@edit')->name('accounting.chartofaccounts.edit');
        Route::post('/{id}/update', 'ChartOfAccountsController@update')->name('accounting.chartofaccounts.update');
        Route::delete('/{id}/delete', 'ChartOfAccountsController@delete')->name('accounting.chartofaccounts.delete');
    });

    Route::group(['prefix' => 'accounting/mr'], function () {
        Route::get('/', 'MoneyReceiptController@index')->name('accounting.mr.index');
        Route::get('/create', 'MoneyReceiptController@create')->name('accounting.mr.create');
        Route::post('/store', 'MoneyReceiptController@store')->name('accounting.mr.store');
        Route::get('/{id}/edit', 'MoneyReceiptController@edit')->name('accounting.mr.edit');
        Route::post('/{id}/update', 'MoneyReceiptController@update')->name('accounting.mr.update');
        Route::delete('/{id}/delete', 'MoneyReceiptController@delete')->name('accounting.mr.delete');
        Route::post('/voucher-preview', 'MoneyReceiptController@voucher')->name('accounting.mr.voucher');
    });

    Route::group(['prefix' => 'accounting/payment-receipt'], function () {
        Route::get('/', 'SuppliersPaymentController@index')->name('accounting.payment.index');
        Route::get('/create', 'SuppliersPaymentController@create')->name('accounting.payment.create');
        Route::post('/store', 'SuppliersPaymentController@store')->name('accounting.payment.store');
        Route::get('/{id}/edit', 'SuppliersPaymentController@edit')->name('accounting.payment.edit');
        Route::post('/{id}/update', 'SuppliersPaymentController@update')->name('accounting.payment.update');
        Route::delete('/{id}/delete', 'SuppliersPaymentController@delete')->name('accounting.payment.delete');
        Route::post('/voucher-preview', 'SuppliersPaymentController@voucher')->name('accounting.payment.voucher');
    });

    Route::group(['prefix' => 'accounting/journal'], function () {
        Route::get('/', 'JournalController@index')->name('accounting.journal.index');
        Route::get('/create', 'JournalController@create')->name('accounting.journal.create');
        Route::post('/store', 'JournalController@store')->name('accounting.journal.store');
        Route::get('/{id}/edit', 'JournalController@edit')->name('accounting.journal.edit');
        Route::post('/{id}/update', 'JournalController@update')->name('accounting.journal.update');
        Route::delete('/{id}/delete', 'JournalController@delete')->name('accounting.journal.delete');
        Route::post('/voucher-preview', 'JournalController@voucher')->name('accounting.journal.voucher');
    });
});
