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
            Route::post('/product-list', 'ProductController@getProductListByName')->name('product.name.autocomplete');
            Route::post('/product-code-list', 'ProductController@getProductListByCode')->name('product.code.autocomplete');
            Route::post('/product-price', 'SellPriceController@getProductPrice')->name('product.price');
            Route::post('/product-stock', 'InventoryController@getProductStockQty')->name('product.stockQty');
        });

        Route::group(array('module' => 'Hr', 'namespace' => '\App\Modules\Hr\Http\Controllers'), function () {
            Route::post('/employee-list', 'EmployeesController@getEmployeesListByName')->name('employee.list.autocomplete');
        });

        Route::group(array('module' => 'Crm', 'namespace' => '\App\Modules\Crm\Http\Controllers'), function () {
            Route::post('/customer-list', 'CustomersController@getCustomerListByName')->name('customer.name.autocomplete');
            Route::post('/customer-code-list', 'CustomersController@getCustomerListByCode')->name('customer.code.autocomplete');
            Route::post('/customer-contact-list', 'CustomersController@getCustomerListByContactNo')->name('customer.contact.autocomplete');
        });

        Route::group(array('module' => 'Commercial', 'namespace' => '\App\Modules\Commercial\Http\Controllers'), function () {
            Route::post('/supplier-list', 'SuppliersController@getSupplierListByName')->name('supplier.name.autocomplete');
            Route::post('/supplier-contact-list', 'SuppliersController@getSupplierListByContactNo')->name('supplier.contact.autocomplete');
        });
    });
});


// it should be at the bottom of every routes
Route::get('/{path}', function () {
    return view('home');
});

