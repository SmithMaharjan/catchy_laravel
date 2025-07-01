<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDelete;
use App\Http\Requests\StoreFavouriteSongRequest;
use App\Http\Requests\UpdateFavouriteSongRequest;
use App\Models\Favourite_user_song;
use App\Models\FavouriteSong;
use App\Services\FavServices;
use Illuminate\Support\Facades\Auth;
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
     * Remove the specified resource from storage.
     */
    public function destroy(StoreDelete $request)
    {
        try {
            $attribute = $request->validated();

            $favourite = Favourite_user_song::find($attribute["removeId"]);

            if (!$favourite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Favourite not found',
                ], 404);
            }

            if ($favourite->artist_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.',
                ], 403);
            }

            $favourite->delete();

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
