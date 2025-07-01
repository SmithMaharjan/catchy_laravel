<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavouriteSongController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\UserVoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Support\Str;



Route::post("/register", [UserController::class, "create"]);
Route::post("/login", [UserController::class, "login"]);
Route::post("/logout", [UserController::class, "logout"]);
Route::get("/profile", [UserController::class, "show"])->middleware("auth:api");

Route::get("/getAllArtist", [ArtistController::class, "index"]);
Route::get("/getArtist/{id}", [ArtistController::class, "getSingleArtist"]);

Route::post("/createSong", [SongController::class, "create"])->middleware(['auth:api', 'isArtist']);
Route::get("/getAllSongs", [SongController::class, "index"]);
Route::get("/getArtistSong", [SongController::class, "getArtistSong"])->middleware('auth:api'); //me as an artist my song
Route::get("/getArtistSongNotInAlbum", [SongController::class, "getArtistSongNotInAlbum"])->middleware(['auth:api', 'isArtist']);
Route::delete('/song/{song}', [SongController::class, 'destroy'])->middleware(['auth:api', 'isArtist']);

Route::post("/createAlbum", [AlbumController::class, "create"])->middleware(['auth:api', 'isArtist']);
Route::get("/getAllAlbum", [AlbumController::class, "index"]);
Route::get("/getArtistAlbum", [AlbumController::class, "getArtistAlbum"])->middleware('auth:api');
Route::get("/getSingleArtistAlbum/{artistId}", [AlbumController::class, "getSingleArtistAlbum"])->middleware('auth:api');
Route::get("/getSingleAlbum/{albumId}", [AlbumController::class, "getSingleAlbum"])->middleware('auth:api');
Route::get('/album/{id}', [AlbumController::class, 'show']);
Route::put('/album/{id}', [AlbumController::class, 'update']);
Route::delete("/deleteAlbum", [AlbumController::class, "destroy"])->middleware(['auth:api', 'isArtist']);
Route::get("/findOne/{albumId}", [AlbumController::class, "findOne"])->middleware('auth:api');

Route::post("/addToFavourite", [FavouriteSongController::class, "addToFavourite"])->middleware('auth:api');
Route::get("/getAllLikedSongs", [FavouriteSongController::class, "index"])->middleware('auth:api');
Route::delete("/deleteLikedSongs", [FavouriteSongController::class, "destroy"])->middleware('auth:api');

Route::get("/getUserPlaylist", [PlaylistController::class, "getUserPlaylist"])->middleware('auth:api');
Route::get('/playlist/{id}', [PlaylistController::class, 'show']);
Route::put('/playlist/{id}', [PlaylistController::class, 'update']);
Route::get("/getUserPlaylist/{id}", [PlaylistController::class, "getSinglePlaylist"])->middleware('auth:api');
Route::post("/createPlaylist", [PlaylistController::class, "create"])->middleware('auth:api');
Route::post("/addSongsToPlaylist", [PlaylistController::class, "addSongsToPlaylist"])->middleware('auth:api');
Route::delete("/deletePlaylist", [PlaylistController::class, "destroy"])->middleware(['auth:api', 'isArtist']);
Route::post("/invite", [PlaylistController::class, "invite"])->middleware('auth:api');

Route::post("/comment", [CommentController::class, "create"])->middleware('auth:api');

Route::post("/voteForArtist", [UserVoteController::class, "create"])->middleware('auth:api');
Route::post("/userPost", [UserPostController::class, "create"])->middleware('auth:api');
Route::post("/editPost", [UserPostController::class, "edit"])->middleware('auth:api');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => __($status)], 200)
        : response()->json(['errors' => ['email' => __($status)]], 422);
});

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return response()->json([
        "success" => $status === PASSWORD::PASSWORD_RESET ? true : false,
        "message" => __($status)
    ]);
});
