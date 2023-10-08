<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        // When logging in with an invalid email address and/or password, I want to receive a 422 response with error messages.
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        // When logging in with a non-existent email address, I want to receive a 404 response.
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response('', 404);
        }

        // When logging in with an existing email address and password, I want to receive a 200 response with the user data and a token
        $token = $user->createToken($user->email)->plainTextToken;
        $response = [
            'user'      => $user,
            'token'     => $token,
        ];
        return response($response, 200);
    }

    public function register(RegisterRequest $request)
    {
        // When signing up with an invalid email address and password, I want to receive a 422 response with error messages
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // When signing up with a valid email address and password, I want to receive a 200 response with the user data and a token
        $token = $user->createToken($user->email)->plainTextToken;
        $response = [
            'user'      => $user,
            'token'     => $token,
        ];
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        // When logged in, I should be able to log out and receive a 204 response.
        return response('', 204);
    }
}
