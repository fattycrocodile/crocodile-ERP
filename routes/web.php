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
            Route::post('/employee-list-phone', 'EmployeesController@getEmployeesListByPhone')->name('employee.phone.autocomplete');
            Route::post('/employee-list-for-attendance', 'AttendanceController@getEmployeesListForAttendance')->name('employee.list.attendance');
            Route::post('/employee-list-for-salary', 'SalarySetupController@getEmployeesListForSalary')->name('employee.list.salary-setup');
        });

        Route::group(array('module' => 'Crm', 'namespace' => '\App\Modules\Crm\Http\Controllers'), function () {
            Route::post('/customer-list', 'CustomersController@getCustomerListByName')->name('customer.name.autocomplete');
            Route::post('/customer-code-list', 'CustomersController@getCustomerListByCode')->name('customer.code.autocomplete');
            Route::post('/customer-contact-list', 'CustomersController@getCustomerListByContactNo')->name('customer.contact.autocomplete');
            Route::post('/due-invoice-list', 'InvoiceController@getDueInvoiceList')->name('crm.invoice.due_invoice');
        });

        Route::group(array('module' => 'SupplyChain', 'namespace' => '\App\Modules\SupplyChain\Http\Controllers'), function () {
            Route::post('/area-list', 'AreaController@getAreaListByName')->name('area.name.autocomplete');
            Route::post('/area-list-code', 'AreaController@getAreaListByCode')->name('area.code.autocomplete');

            Route::post('/territory-list', 'TerritoryController@getTerritoryListByName')->name('territory.name.autocomplete');
            Route::post('/territory-list-code', 'TerritoryController@getTerritoryListByCode')->name('territory.code.autocomplete');
        });

        Route::group(array('module' => 'Commercial', 'namespace' => '\App\Modules\Commercial\Http\Controllers'), function () {
            Route::post('/supplier-list', 'SuppliersController@getSupplierListByName')->name('supplier.name.autocomplete');
            Route::post('/supplier-contact-list', 'SuppliersController@getSupplierListByContactNo')->name('supplier.contact.autocomplete');
            Route::post('/due-purchase-list', 'PurchaseController@getDuePurchaseList')->name('payment.purchase.due_purchase');
            Route::post('/due-purchase-list-due', 'PurchaseController@getDuePurchaseListWithDue')->name('payment.purchase.due_purchase_due');
        });
    });
});


// it should be at the bottom of every routes
Route::get('/{path}', function () {
    return view('home');
});

