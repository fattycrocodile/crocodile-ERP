<?php

use App\Modules\SupplyChain\Http\Controllers\AreaController;
use App\Modules\SupplyChain\Http\Controllers\TerritoryController;
use App\Modules\Crm\Http\Controllers\SellOrderController;
use Illuminate\Support\Facades\Route;

Route::get('supply-chain', 'SupplyChainController@welcome');


Route::group(['prefix' => 'supply-chain/', 'middleware' => ['auth:web'], 'as' => 'supplyChain.'], function () {

    Route::group(['prefix' => 'area', 'as' => 'area.'], function () {
        Route::get('/', [AreaController::class, 'index'])->name('index');
        Route::get('/create', [AreaController::class, 'create'])->name('create');
        Route::post('/store', [AreaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AreaController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [AreaController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [AreaController::class, 'delete'])->name('delete');
    });


    Route::group(['prefix' => 'territory', 'as' => 'territory.'], function () {
        Route::get('/', [TerritoryController::class, 'index'])->name('index');
        Route::get('/create', [TerritoryController::class, 'create'])->name('create');
        Route::post('/store', [TerritoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TerritoryController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [TerritoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [TerritoryController::class, 'delete'])->name('delete');
    });


});

Route::group(['prefix' => 'supply-chain/reports'], function () {

    Route::get('/area_wise_sales_order_report', [SellOrderController::class, 'areaOrderReport'])->name('supply-chain.reports.area-wise-sell-order');
    Route::post('/area_wise_sales_order_report_view', [SellOrderController::class,'areaOrderReportView'])->name('supply-chain.reports.area-wise-sell-order-view');

    Route::get('/territory_wise_sales_order_report', [SellOrderController::class, 'areaOrderReport'])->name('supply-chain.reports.territory-wise-sell-order');
    Route::post('/territory_wise_sales_order_report_view', [SellOrderController::class,'areaOrderReportView'])->name('supply-chain.reports.territory-wise-sell-order-view');

    Route::get('/asm_wise_sales_order_report', [SellOrderController::class, 'areaOrderReport'])->name('supply-chain.reports.asm-wise-sell-order');
    Route::post('/area_wise_sales_order_report_view', [SellOrderController::class,'areaOrderReportView'])->name('supply-chain.reports.asm-wise-sell-order-view');

    Route::get('/tso_wise_sales_order_report', [SellOrderController::class, 'areaOrderReport'])->name('supply-chain.reports.tso-wise-sell-order');
    Route::post('/tso_wise_sales_order_report_view', [SellOrderController::class,'areaOrderReportView'])->name('supply-chain.reports.tso-wise-sell-order-view');
});
