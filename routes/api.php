<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use const App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);


Route::middleware('jwt.verify')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::get('address/{postcode}', [\App\Http\Controllers\AddressController::class, 'show']);
    Route::prefix('appointment')->group(function () {
        Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\AppointmentController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\AppointmentController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\AppointmentController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\AppointmentController::class, 'destroy']);
    });
});
