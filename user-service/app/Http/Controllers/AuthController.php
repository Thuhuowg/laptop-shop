<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Dùng để mã hóa mật khẩu
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Đăng ký tài khoản mới
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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Lưu thông tin người dùng vào cơ sở dữ liệu (mã hóa mật khẩu)
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Mã hóa mật khẩu
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'role_id' => 1, // Gán role mặc định
            ]);

            return response()->json(['message' => 'Đăng ký thành công!', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tạo tài khoản: ' . $e->getMessage()], 500);
        }
    }

    // Đăng nhập
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Email hoặc mật khẩu không chính xác'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['error' => 'Không thể tạo token'], 500);
    }

    return response()->json([
        'message' => 'Đăng nhập thành công!',
        'token' => $token,
        'user' => Auth::user(),
    ], 200);
}

    // Lấy thông tin người dùng hiện tại
    public function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user, 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token không hợp lệ hoặc đã hết hạn'], 401);
        }
    }

    // Đăng xuất
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Đăng xuất thành công!'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Không thể đăng xuất'], 500);
        }
    }
}