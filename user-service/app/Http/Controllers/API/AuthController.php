<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;

// class AuthController extends Controller
// {
//     // Đăng nhập
//     public function login(Request $request)
//     {
//         // Validate dữ liệu đầu vào
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         // Lấy thông tin người dùng từ cơ sở dữ liệu
//         $user = DB::table('user_pj')->where('email', $request->email)->first();

//         // Kiểm tra thông tin người dùng và mật khẩu
//         if (!$user || $user->password !== $request->password) {
//             return response()->json(['message' => 'Invalid credentials'], 401);
//         }

//         // Tạo token đơn giản (ví dụ: chuỗi ngẫu nhiên)
//         $token = base64_encode(Str::random(40));
//         DB::table('user_pj')->where('email', $request->email)->update(['api_token' => $token]);

//         // Trả về thông tin và token
//         return response()->json([
//             'message' => 'Login successful',
//             'user' => [
//                 'user_id' => $user->user_id,
//                 'email' => $user->email,
//                 'username' => $user->username,
//             ],
//             'token' => $token,
//         ], 200);
//     }

//     // Đăng xuất
//     public function logout(Request $request)
//     {
//         $token = $request->header('Authorization');

//         if (!$token) {
//             return response()->json(['message' => 'No token provided'], 401);
//         }

//         // Xóa token khỏi cơ sở dữ liệu
//         $user = DB::table('users')->where('api_token', $token)->first();

//         if ($user) {
//             DB::table('users')->where('api_token', $token)->update(['api_token' => null]);
//             return response()->json(['message' => 'Logged out successfully'], 200);
//         }

//         return response()->json(['message' => 'Invalid token'], 401);
//     }
//     public function showLoginForm()
//     {
//         return view('auth.login');
//     }
// }
