<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class AuthController extends Controller
{
    // Đăng ký tài khoản mới
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
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
        // Xác thực dữ liệu đầu vào
        $credentials = $request->only('email', 'password');

        try {
            // Kiểm tra thông tin đăng nhập và lấy token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Email hoặc mật khẩu không chính xác'], 401);
            }

            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'token' => $token,
                'user' => JWTAuth::user(), // Lấy thông tin người dùng sau khi đăng nhập
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Không thể tạo token'], 500);
        }
    }

    // Lấy thông tin người dùng hiện tại
    public function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); // Xác thực token và lấy thông tin người dùng
            return response()->json($user, 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token không hợp lệ hoặc đã hết hạn'], 401);
        }
    }

    // Đăng xuất
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // Hủy token
            return response()->json(['message' => 'Đăng xuất thành công!'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Không thể đăng xuất'], 500);
        }
    }
}
