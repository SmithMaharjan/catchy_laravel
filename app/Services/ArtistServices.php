<?php

use App\Models\User;

class ArtistServices
{

    public function index()
    {
        $artists = User::with("role")->whereHas("role", (function ($query) {
            return $query->where("name", "artist");
        }))->get();
        return $artists;
    }
}
