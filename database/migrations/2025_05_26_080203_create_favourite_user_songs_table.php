<?php

use App\Models\FavouriteSong;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favourite_user_songs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, "artist_id")->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Song::class, "song_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_user_songs');
    }
};
