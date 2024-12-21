<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Để làm việc trực tiếp với database
use Illuminate\Support\Facades\Session; // Để quản lý session
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

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

            return response()->json([
                'message' => 'Đăng ký thành công!',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tạo tài khoản: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm user trong cơ sở dữ liệu
        $user = User::where('email', $request->email)
            ->where('password', $request->password) // Nếu không dùng bcrypt
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Kiểm tra nếu user có ID
        if (!$user->user_id) {
            return response()->json(['error' => 'User does not have a valid ID'], 500);
        }

        // Tạo token JWT
        try {
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'message' => 'Login successful!',
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to create token: ' . $e->getMessage()], 500);
        }
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

    // Đăng xuất và vô hiệu hóa token
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
