<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Song extends Model
{
    /** @use HasFactory<\Database\Factories\SongFactory> */
    use HasFactory;
    protected $fillable = [
        "name",
        "artist_id",
        "album_id",
        "audio_path",
        "img_path",
    ];

    protected $appends = ['audio_url'];

    public function getAudioUrlAttribute()
    {
        if ($this->audio_path) {
            $pathParts = explode('/', $this->audio_path);
            $artistFolder = $pathParts[1] ?? '';
            $filename = $pathParts[2] ?? '';

            return "/audio/{$artistFolder}/{$filename}";
        }
        return null;
    }


    public function artist()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
