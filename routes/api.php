<?php

use App\Http\Controllers\App\ConversationController;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\MessageController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
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
Route::prefix('auth')->namespace('Auth')->group(function () {

    //unprotected routes
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/check-username', [AuthController::class, 'checkUsername']);

    // protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });

    // google login
    Route::get('/google', [AuthController::class, "redirectToGoogle"]);
    Route::get('/google/callback', [AuthController::class, "handleGoogleCallback"]);
});


// Applications routes

Route::middleware('auth:sanctum')->namespace('App')->group(function () {

    // profile
    Route::prefix('profile')->group(function() {
        Route::put('/update', [ProfileController::class, 'update']);
    });

    // check username
    Route::get('/check-username/{username}', [HomeController::class, 'checkUsername']);

    // conversations
    Route::prefix('conversation')->group(function () {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{conversation}/messages', [ConversationController::class, 'messages']);
    });

    // messages
    Route::prefix('message')->group(function () {
        Route::get('/store', [MessageController::class, 'store']);
        Route::post('/update', [MessageController::class, 'update']);
        Route::get('/destroy', [MessageController::class, 'destroy']);
    });
});
