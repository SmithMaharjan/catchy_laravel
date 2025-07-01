<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail()
            ], [
                'google_id' => $googleUser->getId(),
                'first_name' => $googleUser->getName(),
                'last_name' => $googleUser->getName(),
                'email_verified_at' => now(),
                'role_id' => 1,
                "img_path" => ""

            ]);
            Auth::login($user);
            $token = $user->createToken('auth_token')->accessToken;

            return redirect()->to("http://localhost:3000/auth/callback?token={$token}&name=" . urlencode($user->first_name));
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }
}
