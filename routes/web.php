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
Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
});

Route::get('/api/product-list','ProductController@getAutocompleteData');

// it should be at the bottom of every routes
Route::get('/{path}', function () {
    return view('home');
});

