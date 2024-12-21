<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Fetch all users (API)
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Show a single user (API)
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    // // Create a new user (API)
    // public function store(Request $request)
    // {
    //     // Validate incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|unique:user_pj|max:255',
    //         'password' => 'required|min:6',
    //         'email' => 'required|email|unique:user_pj,email',
    //         'phone_number' => 'nullable|digits_between:10,15',
    //         'address' => 'nullable|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     try {
    //         // Create a new user
    //         $user = User::create([
    //             'username' => $request->username,
    //             'password' => bcrypt($request->password), // Hash the password before saving
    //             'email' => $request->email,
    //             'phone_number' => $request->phone_number,
    //             'address' => $request->address,
    //             'role_id' => $request->role_id ?? 1, // Default role if not provided
    //         ]);

    //         return response()->json([
    //             'message' => 'User created successfully',
    //             'user' => $user,
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Unable to create user: ' . $e->getMessage()], 500);
    //     }
    // }

    // Update an existing user (API)
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:user_pj,username,' . $id,
            'email' => 'required|email|unique:user_pj,email,' . $id,
            'phone_number' => 'nullable|digits_between:10,15',
            'address' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update user data
        $user->update($request->only('username', 'email', 'phone_number', 'address', 'role_id'));

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // Delete a user (API)
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}

