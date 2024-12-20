<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Để làm việc trực tiếp với database
use Illuminate\Support\Facades\Session; // Để quản lý session

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Đăng ký tài khoản - Lưu thông tin trực tiếp vào DB
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user_pj,username',
            'email' => 'required|email|unique:user_pj,email',
            'password' => 'required|min:6|confirmed',
            'phone_number'=> 'required',
            'address'=> 'required',          
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lưu thông tin trực tiếp vào cơ sở dữ liệu
        DB::table('user_pj')->insert([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), // Lưu mật khẩu thô vào DB
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'role_id' => 1,
        ]);

        return redirect('/login')->with('success', 'Đăng ký tài khoản thành công!');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Đăng nhập người dùng
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kiểm tra thông tin đăng nhập
        $user = DB::table('user_pj')->where('email', $request->email)->first();

        // Kiểm tra người dùng có tồn tại và mật khẩu có đúng không
        if ($user && $user->password === $request->password) {
            // Mật khẩu trùng khớp
            return redirect('/users')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
