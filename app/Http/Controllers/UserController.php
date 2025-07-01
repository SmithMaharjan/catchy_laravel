<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Http\Requests\StoreSessionUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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

            if (isset($attributes['username'])) {
                $nameParts = preg_split('/\s+/', trim($attributes['username']));
                $attributes['first_name'] = $nameParts[0] ?? null;
                $attributes['middle_name'] = count($nameParts) === 3 ? $nameParts[1] : null;
                $attributes['last_name'] = end($nameParts);
                unset($attributes['username']);
            }
            $img = $request->file('image');
            $imgFolderName = 'user' . Auth::id();
            $imgFileName = time() . '.' . $img->getClientOriginalExtension();
            $imgPath = $img->storeAs("people/{$imgFolderName}", $img, 'public');
            $attributes["img_path"] = $imgPath;
            [$user, $token] = $this->user->create($attributes);

            Auth::login($user);
            event(new UserRegister($user));
            return response()->json([
                'success' => true,
                "message" => "User registered",
                "user" => $user,
                "token" => $token
            ])->cookie('access_token', $token, 600, "/", 'localhost', false, false);
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
                'success' => true,
                "message" => "User logged in",
                "user" => $user,
                "token" => $token
            ], 200)->cookie('access_token', $token, 600, "/", 'localhost', false, false);
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


    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => true,
                'message' => 'User logged out'
            ], 200)->cookie('access_token', '', -1, '/', 'localhost', false, false);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Something went wrong during logout',
                'error' => $exception->getMessage()
            ], 500);
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
        try {
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }
}
