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
});
