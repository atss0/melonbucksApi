<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    PasswordController,
    ProfileController,
    RewardController,
    StoreController,
    TableController,
    MenuController,
    CartController,
    OrderController
};

/*
|--------------------------------------------------------------------------
| 🔐 AUTHENTICATION & USER
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    // Public Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
    Route::post('/reset-password', [PasswordController::class, 'resetPassword']);

    // Protected User Actions
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change-password', [PasswordController::class, 'changePassword']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

        Route::put('/profile', [ProfileController::class, 'updateProfile']);
        Route::post('/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar']);

        Route::get('/points', [RewardController::class, 'getPoints']);
        Route::get('/rewards', [RewardController::class, 'getRewards']);
        Route::post('/redeem-reward', [RewardController::class, 'redeemReward']);
    });
});

/*
|--------------------------------------------------------------------------
| 🛒 CART ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update', [CartController::class, 'update']);
    Route::delete('/remove/{id}', [CartController::class, 'remove']);
    Route::delete('/clear', [CartController::class, 'clear']);
});

/*
|--------------------------------------------------------------------------
| 📦 ORDER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::put('/{id}/cancel', [OrderController::class, 'cancel']);
    Route::get('/{id}/status', [OrderController::class, 'status']);
    Route::post('/{id}/rate', [OrderController::class, 'rate']);
});

/*
|--------------------------------------------------------------------------
| 🏪 STORE ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/stores', [StoreController::class, 'index']);
Route::get('/stores/{id}', [StoreController::class, 'show']);
Route::get('/stores-nearby', [StoreController::class, 'nearby']);
Route::post('/stores', [StoreController::class, 'store']);

/*
|--------------------------------------------------------------------------
| 🪑 TABLE ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/{qr_code}', [TableController::class, 'showByQr']);
Route::post('/tables', [TableController::class, 'store']);

/*
|--------------------------------------------------------------------------
| 🍽️ MENU ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'allMenu']);
    Route::get('/categories', [MenuController::class, 'categories']);
    Route::get('/category/{id}', [MenuController::class, 'byCategory']);
    Route::get('/item/{id}', [MenuController::class, 'itemDetail']);
    Route::get('/popular', [MenuController::class, 'popular']);
    Route::get('/search', [MenuController::class, 'search']);
});