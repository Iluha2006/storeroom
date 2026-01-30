<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\WarehouseObjectController;
use App\Http\Controllers\Web\WarehouseCellController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;


Route::get('/', function () {
    return view('app');
})->name('home');


Route::get('/api/cities', [CityController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::prefix('city')->group(function () {

        Route::get('/{citySlug}/cells', [WarehouseCellController::class, 'indexByCity']);
        Route::get('/{citySlug}/{objectSlug}/available', [WarehouseCellController::class, 'index']);
        Route::get('/{citySlug}/available', [WarehouseObjectController::class, 'index']);
        Route::get('/{citySlug}/{objectSlug}', [WarehouseObjectController::class, 'show']);


        Route::get('/{citySlug}', [CityController::class, 'show']);
    });
});
  Route::get('/cellObject/{cellSlug}', [WarehouseCellController::class, 'show']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

