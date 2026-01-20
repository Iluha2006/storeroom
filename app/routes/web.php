<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\RoutePath;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
