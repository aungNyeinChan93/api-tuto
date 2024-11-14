<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email",
            "password" => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return response()->json([
            'message' => 'registeration success!',
            'token' => $token->plainTextToken,
            "data" => $user
        ]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);
        $user = User::query()->where('email', $request->email)->firstOrFail();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                ['message' => 'your credentials is incorrect!']
            );
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'message' => 'login success',
            'token' => $token->plainTextToken,
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => "you are logout !"
        ]);
    }
}
