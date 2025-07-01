<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavourite_user_songRequest;
use App\Http\Requests\UpdateFavourite_user_songRequest;
use App\Models\Favourite_user_song;

class FavouriteUserSongController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavourite_user_songRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Favourite_user_song $favourite_user_song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourite_user_song $favourite_user_song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavourite_user_songRequest $request, Favourite_user_song $favourite_user_song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite_user_song $favourite_user_song)
    {
        //
    }
}
