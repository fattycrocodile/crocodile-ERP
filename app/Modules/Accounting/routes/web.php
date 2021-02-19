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
});
