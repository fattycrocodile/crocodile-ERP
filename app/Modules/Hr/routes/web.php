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

    Route::group(['prefix' => 'hr/leaves'], function () {
        Route::get('/', 'LeaveApplicationController@index')->name('hr.leaves.index');
        Route::get('/create', 'LeaveApplicationController@create')->name('hr.leaves.create');
        Route::post('/store', 'LeaveApplicationController@store')->name('hr.leaves.store');
        Route::get('/{id}/edit', 'LeaveApplicationController@edit')->name('hr.leaves.edit');
        Route::post('/{id}//update', 'LeaveApplicationController@update')->name('hr.leaves.update');
        Route::post('/approve', 'LeaveApplicationController@approve')->name('hr.leaves.approve');
        Route::delete('/{id}/delete', 'LeaveApplicationController@delete')->name('hr.leaves.delete');
    });

    Route::group(['prefix' => 'hr/attendance'], function () {
        Route::get('/', 'AttendanceController@index')->name('hr.attendance.index');
        Route::get('/create', 'AttendanceController@create')->name('hr.attendance.create');
        Route::post('/store', 'AttendanceController@store')->name('hr.attendance.store');
        Route::get('/{id}/edit', 'AttendanceController@edit')->name('hr.attendance.edit');
        Route::post('/{id}//update', 'AttendanceController@update')->name('hr.attendance.update');
        Route::delete('/{id}/delete', 'AttendanceController@delete')->name('hr.attendance.delete');
    });

    Route::group(['prefix' => 'hr/salary'], function () {
        Route::get('/', 'SalarySetupController@index')->name('hr.salary.index');
        Route::get('/create', 'SalarySetupController@create')->name('hr.salary.create');
        Route::post('/store', 'SalarySetupController@store')->name('hr.salary.store');
        Route::get('/{id}/edit', 'SalarySetupController@edit')->name('hr.salary.edit');
        Route::post('/{id}//update', 'SalarySetupController@update')->name('hr.salary.update');
        Route::delete('/{id}/delete', 'SalarySetupController@delete')->name('hr.salary.delete');
    });

    Route::group(['prefix' => 'hr/reports'], function () {
        Route::get('/employees-report', 'EmployeesController@employeesReport')->name('hr.reports.employees-report');
        Route::post('/employees-report-view', 'EmployeesController@employeesReportView')->name('hr.reports.employees-report-view');

        Route::get('/employees-joining-report', 'EmployeesController@joiningReport')->name('hr.reports.joining-report');
        Route::post('/employees-joining-report-view', 'EmployeesController@joiningReportView')->name('hr.reports.joining-report-view');

        Route::get('/attendance-report', 'AttendanceController@attendanceReport')->name('hr.reports.attendance-report');
        Route::post('/attendance-report', 'AttendanceController@attendanceReportView')->name('hr.reports.attendance-report-view');

        Route::get('/salary-sheet', 'SalarySetupController@salarySheet')->name('hr.reports.salary-sheet');
        Route::post('/salary-sheet-view', 'SalarySetupController@salarySheetView')->name('hr.reports.salary-sheet-view');
    });
});
