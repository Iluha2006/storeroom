<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\WarehouseObjectController;
use App\Http\Controllers\Web\WarehouseCellController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;


Route::get('/', function () {
    return view('app');
})->name('home');


Route::prefix('api')->group(function () {
    Route::get('/cities', [CityController::class, 'index']);

    Route::prefix('city')->group(function () {
        Route::get('/{citySlug}/{objectSlug}/available', [WarehouseCellController::class, 'index']);
        Route::get('/{citySlug}/available', [WarehouseObjectController::class, 'index']);
        Route::get('/{citySlug}/{objectSlug}', [WarehouseObjectController::class, 'show']);
        Route::get('/{citySlug}', [CityController::class, 'show']);
    });

    Route::get('/cell/{cellSlug}', [WarehouseCellController::class, 'show']);
});


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

