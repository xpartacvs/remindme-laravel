<?php

use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\ValidateAccessToken;
use App\Http\Middleware\ValidateRefreshToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/session',[SessionController::class, 'login']);

Route::middleware([ValidateRefreshToken::class])->group(function () {
    Route::put('/session',[SessionController::class, 'refresh']);
});

Route::middleware([ValidateAccessToken::class])->group(function () {
    Route::post('/reminders',[ReminderController::class, 'create']);
});