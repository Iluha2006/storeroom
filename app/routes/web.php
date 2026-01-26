<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
=======
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\RoutePath;
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\WarehouseObjectController;
use App\Http\Controllers\Web\WarehouseCellController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;


Route::get('/', function () {
    return view('app');
})->name('home');


<<<<<<< HEAD
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

=======
Route::get('/cities', [CityController::class, 'index']);

Route::prefix('city')->group(function () {
    Route::get('/{citySlug}/{objectSlug}/available', [WarehouseCellController::class, 'index']);
    Route::get('/{citySlug}/available', [WarehouseObjectController::class, 'index']);
    Route::get('/{citySlug}/{objectSlug}', [WarehouseObjectController::class, 'show']);
    Route::get('/{citySlug}', [CityController::class, 'show']);
});

Route::get('/cell/{cellSlug}', [WarehouseCellController::class, 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
