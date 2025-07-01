<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



Route::get('/email/verify', function () {
    return response()->json(['message' => 'Verify your email address.']);
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid hash.'], 403);
    }

    if (! $request->hasValidSignature()) {
        return response()->json(['message' => 'Invalid signature.'], 403);
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect('http://localhost:3000/');
})->middleware('signed')->name('verification.verify');


Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google-callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');


Route::get('/reset-password/{token}', function (string $token, Request $request) {
    $email = $request->query('email');
    $frontendUrl = "http://localhost:3000/reset-password?token={$token}&email={$email}";

    return redirect()->away($frontendUrl);
})->middleware('guest')->name('password.reset');



Route::get('/audio/{folder}/{filename}', function ($folder, $filename) {
    $path = "songs/{$folder}/{$filename}";
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(storage_path("app/public/{$path}"));
});

Route::view("/login", "login");
