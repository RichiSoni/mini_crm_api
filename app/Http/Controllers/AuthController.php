<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation errors', 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json(['message' => 'User registered successfully', 'data' => new UserResource($user)], 201);

    }

    public function login(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //         'email' => 'required|email',
        //         'password' => 'required'
        //     ]);
        // if ($validator->fails()) {
        //     return response()->json(['message' => 'Validation errors', 'errors' => $validator->errors()], 422);
        // }
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Auth::user()->createToken('api')->plainTextToken;

        return response()->json(['message' => 'Login successfully', 'token' => $token], 200);
        
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successfully'], 200);

    }
}
