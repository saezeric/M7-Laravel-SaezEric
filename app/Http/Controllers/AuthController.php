<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:100|in:admin,user',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Creación del usuario
        $user = User::create([
            'name' => $request->get('name'),
            'role' => $request->get('role'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return response()->json(['message' => 'User logged in successfully', 'token' => $token], 200);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token', 'message' => $e->getMessage(),], 500);
        }
    }

    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Users retrieved successfully', 'data' => $users], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => 'User retrieved successfully', 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'role' => 'sometimes|required|string|max:100|in:admin,user',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update($request->only(['name', 'role', 'email', 'password']));

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['message' => 'User retrieved successfully', 'data' => $user,], 200);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'User logged out successfully'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not log out user', 'message' => $e->getMessage(),], 500);
        }
    }
}
