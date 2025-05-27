<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\OrderAdminController;

Route::get('/admin/orders', [OrderAdminController::class, 'index']);
Route::post('/admin/orders/{id}/update-status', [OrderAdminController::class, 'updateStatus']);

Route::get('/reset-password/{token}', function ($token) {
    $email = request()->query('email');
    
    // Email validation
    if (!$email) {
        return response()->json(['error' => 'Email parameter is required'], 400);
    }
    
    // Token validation (optional)
    if (!$token || strlen($token) < 10) {
        return response()->json(['error' => 'Invalid token'], 400);
    }
    
    // URL encode email to handle special characters
    $encodedEmail = urlencode($email);
    
    // Create deep link
    $deepLink = "melonbucks://reset-password?token={$token}&email={$encodedEmail}";
    
    // For mobile devices, redirect to deep link
    $userAgent = request()->header('User-Agent');
    
    if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
        // Mobile device - redirect to app
        return redirect()->away($deepLink);
    } else {
        // Desktop/Web - show a page with instructions
        return view('password-reset-instructions', [
            'deepLink' => $deepLink,
            'email' => $email,
            'token' => $token
        ]);
    }
})->name('password.reset');

// Alternative route for direct app opening (optional)
Route::get('/app/reset-password/{token}', function ($token) {
    $email = request()->query('email');
    
    if (!$email) {
        return response()->json(['error' => 'Email parameter is required'], 400);
    }
    
    $encodedEmail = urlencode($email);
    $deepLink = "melonbucks://reset-password?token={$token}&email={$encodedEmail}";
    
    return redirect()->away($deepLink);
})->name('app.password.reset');