<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
    public function create(StoreCommentRequest $request)
    {
        $attributes = $request->validated();
        $attributes["user_id"] = Auth::id();
        $comment = Comment::create($attributes);
        return response()->json([
            'success' => true,
            "comment" => "new comment added",
            "data" => $comment
        ]);
    }
}
