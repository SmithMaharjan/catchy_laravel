<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserServices
{
    public function create($attributes)
    {
        $user =  User::create($attributes);
        $token = $user->createToken("token")->accessToken;
        return [
            $user,
            $token
        ];
    }

    public function login($attributes)
    {

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                "error" => "the email or the password doesnot match"
            ]);
        }
        $user = Auth::user();
        $token = $user->createToken("token")->accessToken;
        return [
            $user,
            $token
        ];
    }
}
