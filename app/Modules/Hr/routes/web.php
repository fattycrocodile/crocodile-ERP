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

    Route::group(['prefix' => 'hr/departments'], function () {
        Route::get('/', 'DepartmentsController@index')->name('hr.departments.index');
        Route::get('/create', 'DepartmentsController@create')->name('hr.departments.create');
        Route::post('/store', 'DepartmentsController@store')->name('hr.departments.store');
        Route::get('/{id}/edit', 'DepartmentsController@edit')->name('hr.departments.edit');
        Route::post('/{id}//update', 'DepartmentsController@update')->name('hr.departments.update');
        Route::delete('/{id}/delete', 'DepartmentsController@delete')->name('hr.departments.delete');
    });

    Route::group(['prefix' => 'hr/designations'], function () {
        Route::get('/', 'DesignationsController@index')->name('hr.designations.index');
        Route::get('/create', 'DesignationsController@create')->name('hr.designations.create');
        Route::post('/store', 'DesignationsController@store')->name('hr.designations.store');
        Route::get('/{id}/edit', 'DesignationsController@edit')->name('hr.designations.edit');
        Route::post('/{id}//update', 'DesignationsController@update')->name('hr.designations.update');
        Route::delete('/{id}/delete', 'DesignationsController@delete')->name('hr.designations.delete');
    });

    Route::group(['prefix' => 'hr/employees'], function () {
        Route::get('/', 'EmployeesController@index')->name('hr.employees.index');
        Route::get('/create', 'EmployeesController@create')->name('hr.employees.create');
        Route::post('/store', 'EmployeesController@store')->name('hr.employees.store');
        Route::get('/{id}/edit', 'EmployeesController@edit')->name('hr.employees.edit');
        Route::post('/{id}//update', 'EmployeesController@update')->name('hr.employees.update');
        Route::delete('/{id}/delete', 'EmployeesController@delete')->name('hr.employees.delete');
    });
});
