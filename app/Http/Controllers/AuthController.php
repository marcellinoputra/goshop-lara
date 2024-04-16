<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthSignInRequest;
use App\Http\Requests\AuthSignUpRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(AuthSignUpRequest $request): JsonResponse
    {
        $data = $request->validated();

        if(User::query()->where('username', $data['username'])->count() == 1){
            throw new HttpResponseException(response(([
                'errors' => [
                    'username' => [
                        'Username Is Already Exist'
                    ]
                ]
            ])));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $token = Auth::login($user);
        $user->save();

        return (new AuthResource($data))->response([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(AuthSignInRequest $request)
    {
        $data = $request->validated();

//        $credential = $request->only('username', 'password');

        $token = Auth::attempt($data);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
