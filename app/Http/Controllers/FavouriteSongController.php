<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDelete;
use App\Http\Requests\StoreFavouriteSongRequest;
use App\Http\Requests\UpdateFavouriteSongRequest;
use App\Models\Favourite_user_song;
use App\Models\FavouriteSong;
use App\Services\FavServices;
use Illuminate\Support\Facades\DB;

class FavouriteSongController extends Controller
{
    public function __construct(protected FavServices $favServices) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = $this->favServices->getAllFavSongs();
        return response()->json([
            'success' => true,
            "message" => "all user liked songs",
            "fav_songs" => $songs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function addToFavourite(StoreFavouriteSongRequest $request)
    {
        $attributes = $request->validated();
        $favouriteSong =  $this->favServices->addToUserFavSong($attributes);
        return response()->json([
            'success' => true,
            "message" => "added to fav song",
            "song" => $favouriteSong
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavouriteSongRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FavouriteSong $favouriteSong)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavouriteSong $favouriteSong)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavouriteSongRequest $request, FavouriteSong $favouriteSong)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreDelete $request)
    {
        try {
            $attribute = $request->validated();

            $deleted = Favourite_user_song::destroy($attribute["removeId"]);

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
