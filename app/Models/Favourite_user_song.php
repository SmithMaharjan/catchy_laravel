<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite_user_song extends Model
{
    /** @use HasFactory<\Database\Factories\FavouriteUserSongFactory> */
    use HasFactory;
    protected $fillable = [
        "artist_id",
        "song_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "artist_id");
    }

    public function songs()
    {
        return $this->belongsTo(Song::class, "song_id");
    }
    public function favourite()
    {
        return $this->belongsTo(FavouriteSong::class);
    }
}
