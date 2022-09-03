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


// Authentications
Route::prefix('auth')->namespace('Auth')->group(function() {
    
    //unprotected routes
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/check-username', [AuthController::class, 'checkUsername']);
    
    // protected routes
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });
    
    // google login
    Route::get('/google', [AuthController::class, "redirectToGoogle"]);
    Route::get('/google/callback', [AuthController::class, "handleGoogleCallback"]);    
});