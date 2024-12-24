<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Lấy danh sách tất cả người dùng (API)
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Lấy thông tin một người dùng (API)
    public function show($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'Người dùng không tồn tại'], 404);
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
            'username' => 'required|max:255|unique:user_pj,username,' . $id . ',user_id',
            'email' => 'required|email|unique:user_pj,email,' . $id . ',user_id',
            'phone_number' => 'nullable|digits_between:5,10',
            'address' => 'nullable|max:255',
            'password' => 'nullable|min:6', // Password must be at least 8 characters
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update user data
        $user->update($request->only('username', 'email', 'phone_number', 'address', 'role_id'));

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    // Xóa người dùng (API)
    public function destroy($user_id)
    {
        // Lấy thông tin người dùng theo user_id
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'Người dùng không tồn tại'], 404);
        }

        // Xóa người dùng
        $user->delete();

        // Trả về thông báo thành công
        return response()->json(['message' => 'Xóa người dùng thành công']);
    }
}
