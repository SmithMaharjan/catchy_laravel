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
        try {
            $artist = User::where("role_id", 2)->get();
            return response()->json([
                'success' => true,
                "message" => "all artist",
                "artists" => $artist
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artist not found'
            ], 404);
        }
    }
    public function getSingleArtist($artistId)
    {
        try {
            $artist = User::where("id", $artistId)->where("role_id", 2)->get();
            return response()->json([
                'success' => true,
                "message" => "single artist",
                "artists" => $artist
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                "message" => "artist not found",
            ]);
        }
    }

    public function artistExist($artistId)
    {
        $artist = User::find($artistId);
        return $artist;
    }
}
