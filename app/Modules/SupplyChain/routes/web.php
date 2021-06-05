<?php

use App\Modules\SupplyChain\Http\Controllers\AreaController;
use App\Modules\SupplyChain\Http\Controllers\TerritoryController;
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
