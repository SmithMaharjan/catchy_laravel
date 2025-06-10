<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable, MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, PasswordsCanResetPassword;
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "role_id",
    ];

    protected $casts = [
        'password' => 'hashed'
    ];
    protected $hidden = [
        'password'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function favourite_user_song()
    {
        return $this->hasMany(Favourite_user_song::class);
    }

    public function playlist()
    {
        return $this->hasMany(Playlist::class, "user_playlist");
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function vote()
    {
        return $this->hasMany(User_vote::class, "vote_artist");
    }
}
