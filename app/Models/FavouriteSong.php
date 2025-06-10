<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteSong extends Model
{
    /** @use HasFactory<\Database\Factories\FavouriteSongFactory> */
    use HasFactory;
    protected $fillable = [
        "song_id"
    ];
    public function favourite_user_song()
    {
        return $this->hasMany(Favourite_user_song::class);
    }
}
