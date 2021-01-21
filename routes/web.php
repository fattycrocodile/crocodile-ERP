<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::get('/settings', 'SettingController@index')->name('admin.settings');
    Route::post('/settings', 'SettingController@update')->name('admin.settings.update');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@index')->name('admin.categories.index');
        Route::get('/create', 'CategoryController@create')->name('admin.categories.create');
        Route::post('/store', 'CategoryController@store')->name('admin.categories.store');
        Route::get('/{id}/edit', 'CategoryController@edit')->name('admin.categories.edit');
        Route::post('/update', 'CategoryController@update')->name('admin.categories.update');
        Route::get('/{id}/delete', 'CategoryController@delete')->name('admin.categories.delete');
    });
});



// it should be at the bottom of every routes
Route::get('/{path}', function () {
    return view('home');
});

