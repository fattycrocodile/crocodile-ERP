<?php
use Illuminate\Support\Facades\Route;

Route::get('crm', 'CrmController@welcome');

Route::group(['middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'crm/customers'], function () {
        Route::get('/', function (\App\DataTables\CustomersDataTable $dataTable){
            return $dataTable->render('Crm::customers.index');
        })->name('crm.customers.index');
//        Route::get('/', 'CustomersController@index')->name('crm.customers.index');
        Route::get('/create', 'CustomersController@create')->name('crm.customers.create');
        Route::post('/store', 'CustomersController@store')->name('crm.customers.store');
        Route::get('/{id}/edit', 'CustomersController@edit')->name('crm.customers.edit');
        Route::post('/{id}/update', 'CustomersController@update')->name('crm.customers.update');
        Route::delete('/{id}/delete', 'CustomersController@delete')->name('crm.customers.delete');
    });
});
