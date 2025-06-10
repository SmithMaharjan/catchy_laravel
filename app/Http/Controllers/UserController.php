<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Http\Requests\StoreSessionUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(protected UserServices $user) {}
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
    public function create(StoreUserRequest $request)
    {
        try {
            $attributes = $request->validated();
            [$user, $token] = $this->user->create($attributes);
            event(new UserRegister($user));
            Auth::login($user);
            return response()->json([
                "message" => "User registered",
                "user" => $user,
                "token" => $token
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "validation error",
                "error" => $exception->getMessage()
            ], 403);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "something went wrong",
            ]);
        }
    }

    public function login(StoreSessionUserRequest $request)
    {
        try {
            $attributes = $request->validated();
            $User = $this->user->login($attributes);
            [$user, $token] = $User;
            return response()->json([
                "message" => "User logged in",
                "user" => $user,
                "token" => $token
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                "message" => "validation error",
                "error" => $exception->getMessage()
            ], 403);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "something went wrong",
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function userExist($userId)
    {
        $user = User::find($userId);
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
