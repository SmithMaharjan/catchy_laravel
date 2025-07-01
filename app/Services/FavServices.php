<?php

namespace App\Services;

use App\Http\Requests\StoreFavouriteSongRequest;
use App\Models\Favourite_user_song;
use App\Models\FavouriteSong;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class FavServices
{

    public function addToUserFavSong($attributes)
    {
        $songId = $attributes["song_id"];
        $user = Auth::user();
        $songExist = $this->findOne($songId);
        if ($songExist) {
            $this->RemoveFromFav($songId);
            return;
        }
        $userFav = Favourite_user_song::create([
            "artist_id" => $user->id,
            "song_id" => $songId,
        ]);
        return response()->json([
            'success' => true,
            "message" => "song added to fav"
        ]);
    }

    public function findOne($songId)
    {
        $song = Favourite_user_song::where('song_id', $songId)->where('artist_id', Auth::id())->first();
        return $song;
    }

    public function RemoveFromFav($id)
    {
        $song = Favourite_user_song::where("song_id", $id)->where("artist_id", Auth::id())->delete();
    }

    public function getAllFavSongs()
    {
        $songs = Favourite_user_song::with('songs')->where('artist_id', Auth::id())->get();
        return $songs;
    }
}
