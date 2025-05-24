<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/register", [UserController::class, "create"]);
Route::post("/login", [UserController::class, "login"]);

Route::get("/getAllArtist", [ArtistController::class, "index"]);
Route::post("/createSong", [SongController::class, "create"]);
Route::get("/getAllSongs", [SongController::class, "index"]);

Route::post("/createAlbum", [AlbumController::class, "create"])->middleware('auth:api');
