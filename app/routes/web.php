<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\RoutePath;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\WarehouseObjectController;
use App\Http\Controllers\Web\WarehouseCellController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

if (Features::enabled(Features::registration())) {
    Route::post(RoutePath::for('register', '/register'), [CustomRegisteredUserController::class, 'store'])
        ->middleware(['guest:' . config('fortify.guard')])
        ->name('register.store');
}

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
