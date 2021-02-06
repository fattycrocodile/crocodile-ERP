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


    //api list for autocomplete/select2 and others
    Route::group(['prefix' => 'api'], function () {
        Route::group(array('module' => 'StoreInventory', 'namespace' => '\App\Modules\StoreInventory\Http\Controllers'), function () {
            Route::post('/product-list', 'ProductController@getProductListByName')->name('productNameAutoComplete');
            Route::post('/product-code-list', 'ProductController@getProductListByCode')->name('productCodeAutoComplete');
            Route::post('/product-price', 'SellPriceController@getProductPrice')->name('productPrice');
            Route::post('/product-stock', 'InventoryController@getProductStockQty')->name('productStockQty');
        });

        Route::group(array('module' => 'Crm', 'namespace' => '\App\Modules\Crm\Http\Controllers'), function () {
            Route::post('/customer-list', 'CustomersController@getCustomerListByName')->name('customerNameAutoComplete');
            Route::post('/customer-code-list', 'CustomersController@getCustomerListByCode')->name('customerCodeAutoComplete');
        });
    });
});


// it should be at the bottom of every routes
Route::get('/{path}', function () {
    return view('home');
});

