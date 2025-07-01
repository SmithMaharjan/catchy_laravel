<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_post extends Model
{
    /** @use HasFactory<\Database\Factories\UserPostFactory> */
    use HasFactory;
    protected $fillable = [
        "description",
        "user_id"
    ];
}
