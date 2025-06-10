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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;



Route::post("/register", [UserController::class, "create"]);
Route::post("/login", [UserController::class, "login"]);

Route::get("/getAllArtist", [ArtistController::class, "index"]);
Route::post("/createSong", [SongController::class, "create"]);
Route::get("/getAllSongs", [SongController::class, "index"]);

Route::post("/createAlbum", [AlbumController::class, "addSongsInAlbum"])->middleware('auth:api');

Route::post("/addToFavourite", [FavouriteSongController::class, "addToFavourite"])->middleware('auth:api');
Route::get("/getAllLikedSongs", [FavouriteSongController::class, "index"])->middleware('auth:api');

Route::post("/createPlaylist", [PlaylistController::class, "create"])->middleware('auth:api');
Route::post("/invite", [PlaylistController::class, "invite"])->middleware('auth:api');

Route::post("/comment", [CommentController::class, "create"])->middleware('auth:api');

Route::post("/voteForArtist", [UserVoteController::class, "create"])->middleware('auth:api');
Route::post("/userPost", [UserPostController::class, "create"])->middleware('auth:api');
Route::post("/editPost", [UserPostController::class, "edit"])->middleware('auth:api');






// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
