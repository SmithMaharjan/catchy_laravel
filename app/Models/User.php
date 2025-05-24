<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
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
}
