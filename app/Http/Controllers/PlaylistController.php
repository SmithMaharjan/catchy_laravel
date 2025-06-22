<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeleteIdRequest;
use App\Http\Requests\StoreDeletePlaylist;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\StorePlaylistSongRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getUserPlaylist()
    {
        $user = Auth::user();
        $playlist = $user->playlists()->with('songs')->get();
        return response()->json([
            'success' => true,

            "message" => "user playlist",
            "playlist" => $playlist
        ]);
    }

    public function getSinglePlaylist($playlistId)
    {
        $playlist = Playlist::with('songs')->find($playlistId);
        return response()->json([
            'success' => true,

            "message" => "single playlist",
            "playlist" => $playlist
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StorePlaylistRequest $request)
    {
        $attributes = $request->validated();


        $img = $request->file('image');
        $imgFolderName = 'cover_' . Auth::id();
        $imgFileName = time() . '.' . $img->getClientOriginalExtension();
        $imgPath = $img->storeAs("playlist/{$imgFolderName}", $imgFileName, 'public');
        $attributes["img_path"] = $imgPath;
        $playlist = Playlist::create($attributes);
        $playlist->user()->attach(Auth::id());

        return response()->json([
            'success' => true,

            "playlist" => "playlist created"
        ]);
    }

    public function addSongsToPlaylist(StorePlaylistSongRequest $request)
    {

        $playlist = Playlist::findOrFail($request["playlist_id"]);
        $playlist->songs()->syncWithoutDetaching($request->song_ids);

        return response()->json(
            [
                'message' => 'Songs added to playlist',
                'success' => true
            ]
        );
    }

    public function invite(Request $request)
    {
        $playlistId = $request->input('id');
        $userId = $request->input('userId');
        $playlist = Playlist::find($playlistId);
        $playlist->user()->attach($userId);
        // dd($playlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaylistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json([
                'success' => false,
                'message' => 'Playlist not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'playlist' => $playlist,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_collaborative' => 'required|boolean',
            'description' => 'nullable|string',
            'img_path' => 'nullable|string',
        ]);

        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json([
                'success' => false,
                'message' => 'Playlist not found',
            ], 404);
        }

        $playlist->name = $request->name;
        $playlist->is_collaborative = $request->is_collaborative;
        $playlist->description = $request->description;
        $playlist->img_path = $request->img_path;

        $playlist->save();

        return response()->json([
            'success' => true,
            'message' => 'Playlist updated successfully',
            'playlist' => $playlist,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreDeletePlaylist $request)
    {
        try {
            $attribute = $request->validated();

            $deleted = Playlist::destroy($attribute["removeId"]);

            return response()->json([
                'success' => true,
                'message' => 'Album deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the album',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
