<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $artist = User::where("role_id", 2)->get();
        return response()->json([
            'success' => true,
            "message" => "all artist",
            "artists" => $artist
        ]);
    }
    public function getSingleArtist($artistId)
    {
        //
        $artist = User::where("id", $artistId)->where("role_id", 2)->get();
        return response()->json([
            'success' => true,
            "message" => "single artist",
            "artists" => $artist
        ]);
    }

    public function artistExist($artistId)
    {
        $artist = User::find($artistId);
        return $artist;
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
    public function store(StoreArtistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
