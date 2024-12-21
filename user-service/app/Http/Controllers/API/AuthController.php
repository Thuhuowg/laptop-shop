<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    // Đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $user = User::where('email', $request->email)->first();

        // Kiểm tra thông tin người dùng và mật khẩu
        if (!$user || $user->password !== $request->password) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }


        // Trả về thông tin và token
        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'username' => $user->username,
            ],
            'token' => $token,
        ], 200);
    }
    // Lấy thông tin người dùng từ token
    public function getUser(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token is invalid or expired'], 401);
        }

        return response()->json(['user' => $user], 200);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());
            return response()->json(['message' => 'Logout successful'], 200);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Failed to logout, please try again'], 500);
        }
    }
    // public function register(Request $request)
    // {
    //     // Validate dữ liệu đầu vào
    //     $request->validate([
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|email|unique:user_pj,email',
    //         'password' => 'required|string|min:6|confirmed', // Yêu cầu nhập lại mật khẩu
    //     ]);

    //     try {
    //         // Tạo người dùng mới
    //         $user = User::create([
    //             'username' => $request->username,
    //             'email' => $request->email,
    //             'password' => $request->password,
    //         ]);

    //         // Tạo JWT token cho người dùng
    //         $token = JWTAuth::fromUser($user);

    //         // Trả về thông tin người dùng và token
    //         return response()->json([
    //             'message' => 'Registration successful',
    //             'user' => [
    //                 'user_id' => $user->user_id,
    //                 'email' => $user->email,
    //                 'username' => $user->username,
    //             ],
    //             'token' => $token,
    //         ], 201);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Registration failed',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user_pj,username',
            'email' => 'required|email|unique:user_pj,email',
            'password' => 'required|min:6|confirmed',
            'phone_number' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Lưu thông tin người dùng vào cơ sở dữ liệu (mật khẩu không mã hóa)
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password, // Không mã hóa mật khẩu
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'role_id' => 1, // Gán role mặc định
            ]);
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'message' => 'Đăng ký thành công!',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tạo tài khoản: ' . $e->getMessage()], 500);
        }
    }
}
