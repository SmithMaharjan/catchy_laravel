<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser_voteRequest;
use App\Http\Requests\UpdateUser_voteRequest;
use App\Models\User;
use App\Models\User_vote;
use Illuminate\Support\Facades\Auth;

class UserVoteController extends Controller
{
    public function __construct(protected UserController $user) {}
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
    public function create(StoreUser_voteRequest $request)
    {
        $attributes = $request->validated();
        $artistId = $attributes["artist_id"];
        $attributes["user_id"] = Auth::id();
        $userId = Auth::id();
        if (!$this->user->userExist($userId)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $existingVote = $this->voteExist($artistId, $userId);

        if ($existingVote) {
            $existingVote->delete();
            return response()->json([
                "message" => "unvoted"
            ]);
        } else {
            User_vote::create($attributes);
            return response()->json([
                "message" => "voted"
            ]);
        }
    }

    public function voteExist($artistId, $userId)
    {
        $vote = User_vote::where([
            "artist_id" => $artistId,
            "user_id" => $userId
        ])->first();
        return $vote;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser_voteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_vote $User_vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_vote $User_vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_voteRequest $request, User_vote $User_vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_vote $User_vote)
    {
        //
    }
}
