<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Requests\Auth\SignInRequest;
// use Illuminate\Contracts\Auth\Authenticatable;

// use PhpOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $validated = $request->validated();


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            
        ]);

        $token = auth()->login($user);

        if (!$token)
        {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Cannot add user.'
                ] ,
                'data' => [] ,
            ], 500);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User created successfully'
            ] ,
            'data' => [
                'user' =>[
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'access token' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . 'minutes'),
                ]
            ] ,
        ]);
    }

    Public function signIn(SignInRequest $request)
    {
        $token = auth()->attempt($request->validated());

        if(!$token)
        {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Incorect email or password',
                ],
                'data' => [],
            ],401);
        }

        $user = auth()->user();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Signed in Successfully'
            ],
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,


                ],
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . 'minutes'),
                ]
            ],
        ], 200);
    }

    public function signOut()
    {
        auth()->logout();

        return response()->json([
            'meta' => [
                'code' =>200,
                'status' => 'success',
                'message' => 'Signed out successfully',
            ],
            'data' => [],

        ]);
    }

    public function refresh()
    {
        $user = auth()->user();
        $token = auth()->fromUser($user);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Token refreshed successfully.',
            ],
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL() . ' minutes'),
                ]
            ],
        ]);
    }
}