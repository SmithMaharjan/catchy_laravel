<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Config\Exception\ValidationException;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $songs = Song::with("artist")->get();
    //     $songs->each(function ($song) {
    //         $song->audio_url = $song->audio_path ? Storage::url($song->audio_path) : null;
    //     });
    //     // dd($songs->toArray());
    //     return response()->json([
    //         "message" => "all songs",
    //         "songs" => $songs,
    //     ]);
    // }
    public function index()
    {
        $songs = Song::with("artist")->get();
        $songs->each(function ($song) {
            if ($song->audio_path) {
                $pathParts = explode('/', $song->audio_path);
                $artistFolder = $pathParts[1] ?? '';
                $filename = $pathParts[2] ?? '';
                $song->audio_url = "/audio/{$artistFolder}/{$filename}";
            } else {
                $song->audio_url = null;
            }
        });
        return response()->json([
            'success' => true,
            "message" => "all songs",
            "songs" => $songs,
        ]);
    }

    public function getArtistSong()
    {
        $id = Auth::id();
        $songs = Song::with("playlists")->where("artist_id", $id)->get();
        return response()->json([
            'success' => true,
            "message" => "artist songs",
            "songs" => $songs,
        ]);
    }

    public function getArtistSongNotInAlbum()
    {
        $id = Auth::id();
        $songs = Song::with("playlists")->where("artist_id", $id)->where("album_id", null)->get();
        return response()->json([
            'success' => true,
            "message" => "artist songs",
            "songs" => $songs,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreSongRequest $request)
    {
        try {

            $attributes = $request->validated();
            $attributes["artist_id"] = Auth::id();

            $audio = $request->file('audio');
            $folderName = 'artist_' . Auth::id();
            $fileName = time() . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs("songs/{$folderName}", $fileName, 'public');
            $attributes["audio_path"] = $path;

            $img = $request->file('image');
            $imgFolderName = 'cover_' . Auth::id();
            $imgFileName = time() . '.' . $img->getClientOriginalExtension();
            $imgPath = $img->storeAs("songs/{$imgFolderName}", $imgFileName, 'public');
            $attributes["img_path"] = $imgPath;

            $song = Song::create($attributes);
            return response()->json([
                'success' => true,
                "message" => "song added",
                "song" => $song
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "validation error",
                "error" => $exception->getMessage()
            ], 403);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "something went wrong",
                "error" => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSongRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        try {
            if ($song->artist_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $song->delete();

            return response()->json([
                'success' => true,
                'message' => 'Song deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the song',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
