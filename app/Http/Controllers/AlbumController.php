<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddSongsInAlbumRequest;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($attributes)
    {
        $user = Auth::user();
        if ($user->role->name !== "artist") {
            return response()->json([
                "message" => "only artist can create album"
            ]);
        }
        $attributes["artist_id"] = $user->id;
        $artist = Album::create($attributes);
        return $artist;
    }


    public function addSongsInAlbum(StoreAddSongsInAlbumRequest $request)
    {
        $albumAttributes = [
            "name" => $request->album_name
        ];
        $album = $this->create($albumAttributes);
        foreach ($request->songs as $song) {
            $songModel = Song::find($song['id']);
            if ($songModel) {
                $songModel->update([
                    'name' => $song['name'],
                    'artist_id' => Auth::id(),
                    'album_id' => $album->id,
                ]);
            } else {
                Song::create([
                    'name' => $song['name'],
                    'artist_id' => Auth::id(),
                    'album_id' => $album->id,
                ]);
            }
        }
        return response()->json([
            "album created with your songs"
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }
}
