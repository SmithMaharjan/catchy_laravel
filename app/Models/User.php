<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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
        "google_id",
        "img_path",
        "email_verified_at"
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
        return $this->hasMany(Album::class, "artist_id");
    }

    public function favourite_user_song()
    {
        return $this->hasMany(Favourite_user_song::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'user_playlist', 'user_id', 'playlist_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function vote()
    {
        return $this->hasMany(User_vote::class, "vote_artist");
    }

    // protected function isLiked()
    // {
    //     return Attribute::make(
    //         get: fn() => $this->favourite_user_song()->where('artist_id', Auth::id())->isNotEmpty()
    //     );
    // }
}
