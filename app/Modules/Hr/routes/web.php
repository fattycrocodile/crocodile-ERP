<?php
use Illuminate\Support\Facades\Route;
Route::get('hr', 'HrController@welcome');

Route::group(['middleware' => ['auth:web']], function () {
    Route::group(['prefix' => 'hr/holidaysetup'], function () {
        Route::get('/', 'HolidaySetupController@index')->name('hr.holidaysetup.index');
        Route::get('/create', 'HolidaySetupController@create')->name('hr.holidaysetup.create');
        Route::post('/store', 'HolidaySetupController@store')->name('hr.holidaysetup.store');
        Route::get('/{id}/edit', 'HolidaySetupController@edit')->name('hr.holidaysetup.edit');
        Route::post('/{id}//update', 'HolidaySetupController@update')->name('hr.holidaysetup.update');
        Route::delete('/{id}/delete', 'HolidaySetupController@delete')->name('hr.holidaysetup.delete');
    });
});
