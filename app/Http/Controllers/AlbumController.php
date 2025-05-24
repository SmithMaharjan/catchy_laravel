<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
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
    public function create(StoreAlbumRequest $request)
    {
        try {
            $user = Auth::user();
            if ($user->role->name !== "artist") {
                return response()->json([
                    "message" => "only artist can create album"
                ]);
            }
            $attributes = $request->validated();
            $attributes["artist_id"] = $user->id;
            $artist = Album::create($attributes);
            return response()->json([
                "message" => "created album",
                "album" => $artist,
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "validation error",
                "error" => $exception->getMessage()
            ], 403);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "something went wrong while creating album",
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function addSongsInAlbum() {}

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
