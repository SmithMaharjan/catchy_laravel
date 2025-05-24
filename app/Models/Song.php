<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /** @use HasFactory<\Database\Factories\SongFactory> */
    use HasFactory;
    protected $fillable = [
        "name",
        "artist_id",
        "album_id"
    ];

    public function artist()
    {
        return $this->belongsTo(User::class);
    }
}
