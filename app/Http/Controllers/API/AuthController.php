<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $user->createToken('userToken')->plainTextToken;

        return response()->json([
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logout'
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } catch (Exception $exception) {
            return response()->json([
               'code' => 500,
               'message' => 'Failed to create a new account'
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success'
        ],200);
    }
}
