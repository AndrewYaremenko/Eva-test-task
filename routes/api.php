<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SalonController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\AppointmentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'salons', 'as' => 'api.salons.'], function () {
    Route::get('/', [SalonController::class, 'index'])->name('index');
    Route::post('/', [SalonController::class, 'store'])->name('store');
    Route::get('/{id}', [SalonController::class, 'show'])->name('show');
    Route::put('/{id}', [SalonController::class, 'update'])->name('update');
    Route::delete('/{id}', [SalonController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'services', 'as' => 'api.services.'], function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
    Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'appointments', 'as' => 'api.appointments.'], function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('index');
    Route::post('/', [AppointmentController::class, 'store'])->name('store');
    Route::get('/{id}', [AppointmentController::class, 'show'])->name('show');
    Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
    Route::delete('/{id}', [AppointmentController::class, 'destroy'])->name('destroy');
    Route::get('/hours/free', [AppointmentController::class, 'freeHours'])->name('freeHours');
});
