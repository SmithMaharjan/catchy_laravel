<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_vote extends Model
{
    protected $table = "vote_artist";
    protected $fillable = [
        "artist_id",
        "user_id"
    ];
    /** @use HasFactory<\Database\Factories\UserVoteFactory> */
    use HasFactory;
    public function user()
    {
        return $this->belongsToMany(User::class, "vote_artist");
    }
}
