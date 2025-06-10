<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser_postRequest;
use App\Http\Requests\UpdateUser_postRequest;
use App\Models\User_post;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
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
    public function create(StoreUser_postRequest $request)
    {
        $attributes = $request->validated();
        $attributes["user_id"] = Auth::id();
        $user_post = User_post::create($attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser_postRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_post $user_post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $description = request()->input('description');
        User_post::where('user_id', Auth::id())->update([
            'description' => $description
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_postRequest $request, User_post $user_post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_post $user_post)
    {
        //
    }
}
