<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteSongRequest;
use App\Http\Requests\UpdateFavouriteSongRequest;
use App\Models\FavouriteSong;
use App\Services\FavServices;

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
            "message" => "all liked songs",
            "fav_songs" => $songs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    public function addToFavourite(StoreFavouriteSongRequest $request)
    {
        $attributes = $request->validated();
        $favouriteSong =  $this->favServices->addToUserFavSong($attributes);
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
    public function destroy(FavouriteSong $favouriteSong)
    {
        //
    }
}
