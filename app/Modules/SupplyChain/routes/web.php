<?php

use App\Modules\SupplyChain\Http\Controllers\AreaController;
use App\Modules\SupplyChain\Models\Territory;
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
        Route::get('/', [Territory::class, 'index'])->name('index');
        Route::get('/create', [Territory::class, 'create'])->name('create');
        Route::post('/store', [Territory::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Territory::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [Territory::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [Territory::class, 'delete'])->name('delete');
    });
});
