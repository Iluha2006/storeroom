<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\WarehouseCellController;
use App\Http\Controllers\Api\WarehouseObjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('city')->group(function () {
    Route::get('/{citySlug}/{objectSlug}/available', [WarehouseCellController::class, 'index']);
    Route::get('/{citySlug}/available', [WarehouseObjectController::class, 'index']);
    Route::get('/{citySlug}/{objectSlug}', [WarehouseObjectController::class, 'show']);
    Route::get('/list', [CityController::class, 'index']);
    Route::get('/{citySlug}', [CityController::class, 'show']);
});

Route::get('/cell/{cellSlug}', [WarehouseCellController::class, 'show']);
<<<<<<< HEAD

=======
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
