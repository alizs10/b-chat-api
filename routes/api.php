<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// first we check email -> if user not regitered, we send vcode -> check vcode -> set password

// Authentications

Route::prefix('auth')->namespace('Auth')->group(function() {
    
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::post('/verify', [AuthController::class, 'verify']);
    
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
    
    
    // google login
    Route::get('/google', [AuthController::class, "redirectToGoogle"]);
    Route::get('/google/callback', [AuthController::class, "handleGoogleCallback"]);
    
    
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    Route::post('/check-username', [AuthController::class, 'checkUsername']);
});

Route::post('/check-email', [AuthController::class, 'checkEmail']);
Route::post('/check-verification-code', [AuthController::class, 'checkVerificationCode']);
Route::post('/set-password', [AuthController::class, 'setPassword']);
