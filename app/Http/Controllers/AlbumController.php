<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddSongsInAlbumRequest;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\StoreDeleteIdRequest;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $albums = Album::with('songs')->get();

            return response()->json([
                'success' => true,
                'data' => $albums,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getArtistAlbum()
    {
        $user = Auth::user();
        $album = $user->albums()->with('songs')->get();
        return response()->json([
            'success' => true,
            "message" => "artist album",
            "album" => $album
        ]);
    }

    public function getSingleArtistAlbum($artistId)
    {
        $user = Auth::user();
        $artistAlbums = $user->albums()->with('songs')->where("artist_id", $artistId)->get();
        return response()->json([
            'success' => true,
            "message" => "artist album",
            "album" => $artistAlbums
        ]);
    }

    public function getSingleAlbum($albumId)
    {
        $user = Auth::user();
        $artistAlbum = $user->albums()->with('songs')->where("id", $albumId)->get();
        return response()->json([
            'success' => true,
            "message" => "single album",
            "album" => $artistAlbum
        ]);
    }
    public function findOne($albumId)
    {
        $artistAlbum = Album::with('songs')->where("id", $albumId)->get();
        return response()->json([
            'success' => true,
            "message" => "single album",
            "album" => $artistAlbum
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */


    public function create(StoreAddSongsInAlbumRequest $request)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $invalidSongs = [];
            foreach ($request->songs as $songId) {
                $songModel = Song::find($songId);
                if (!$songModel || $songModel->album_id !== null) {
                    $invalidSongs[] = $songModel->name ?? "song id $songId";
                }
            }

            if (count($invalidSongs) > 0) {
                DB::rollBack();
                return response()->json([
                    "some songs are already in an album"
                ]);
            }
            $img = $request->file('image');
            $imgFolderName = 'cover_' . Auth::id();
            $imgFileName = time() . '.' . $img->getClientOriginalExtension();
            $imgPath = $img->storeAs("album/{$imgFolderName}", $imgFileName, 'public');

            $album = Album::create([
                'name' => $request->album_name,
                "artist_id" => $user->id,
                "img_path" => $imgPath
            ]);

            foreach ($request->songs as $songId) {
                $songModel = Song::find($songId);
                $songModel->update([
                    'album_id' => $album->id,
                ]);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Album created with all songs.',
                'album_id' => $album->id,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create album.',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function show($id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json([
                'success' => false,
                'message' => 'Album not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'album' => $album,
        ]);
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
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'img_path' => 'nullable|string',
        ]);

        $album = Album::find($id);

        if (!$album) {
            return response()->json([
                'success' => false,
                'message' => 'Album not found',
            ], 404);
        }

        if ($album->artist_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: cannot edit this album.',
            ], 403);
        }


        $album->name = $request->name;
        $album->img_path = $request->img_path;
        $album->save();

        return response()->json([
            'success' => true,
            'message' => 'Album updated successfully',
            'album' => $album,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreDeleteIdRequest $request)
    {
        try {
            $attribute = $request->validated();

            if ($attribute["artistId"] != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $deleted = Album::destroy($attribute["removeId"]);

            if ($deleted === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Album not found or already deleted'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Album deleted',
                'deletedCount' => $deleted
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
