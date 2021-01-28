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
});
