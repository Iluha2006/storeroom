
<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\CellPriceController;
use App\Http\Controllers\Web\WarehouseObjectController;
use App\Http\Controllers\Web\WarehouseCellController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EmailVerificationRequest;
Route::get('/', function () {
    return view('app');
})->name('home');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }
        $request->user()->sendEmailVerificationNotification();

    })->name('verification.send');


});

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, '__invoke'])
->middleware(['signed'])
->name('verification.verify');


Route::post('/email/resend', [VerificationController::class, 'resend']);

Route::get('/api/cities', [CityController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::prefix('city')->group(function () {

        Route::get('/{citySlug}/cells', [WarehouseCellController::class, 'indexByCity']);
        Route::get('', [WarehouseCellController::class, 'index']);

        Route::get('/{citySlug}/{objectSlug}', [WarehouseObjectController::class, 'show']);


        Route::get('/{citySlug}', [CityController::class, 'show']);
    });
});
Route::get('/cell/{slug}/price', [CellPriceController::class, 'show']);
Route::prefix('auth')->group(function () {

    Route::post('/register', [RegisterController::class, 'register']);

    Route::post('/login', [LoginController::class, 'login']);

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/check-verification', [VerificationController::class, 'checkVerification']) ->middleware(['auth:sanctum']);
});
Route::get('/cells/all', [WarehouseCellController::class, 'indexAll']);
  Route::get('/cellObject/{cellSlug}', [WarehouseCellController::class, 'show']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

