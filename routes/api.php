<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('user', function() {
        return Auth::user();
    });
    Route::resource('loans', LoanController::class);
    Route::resource('users', UserController::class);
    Route::get('users/role/{role}', [UserController::class, 'getUsersByRole']);
});


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    // Find the user based on the ID in the URL
    $user = \App\Models\User::findOrFail($request->route('id'));

    // Check if the hash in the URL matches the user's email
    if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    // Mark the user's email as verified
    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    // Redirect to your Nuxt3 frontend or return a JSON response
    return redirect(config('app.frontend_url') . '/verify');
})->middleware(['signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return response()->json(['message' => 'Email verification is required.'], 403);
})->middleware(['auth:sanctum'])->name('verification.notice');