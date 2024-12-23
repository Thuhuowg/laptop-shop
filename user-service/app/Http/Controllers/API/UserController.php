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

    // Cập nhật thông tin người dùng (API)
    public function update(Request $request, $user_id)
    {
        // Lấy thông tin người dùng theo user_id
        $user = User::findOrFail($user_id);

        if (!$user) {
            return response()->json(['error' => 'Người dùng không tồn tại'], 404);
        }

        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:user_pj,username,' . $user->user_id,
            'email' => 'required|email|unique:user_pj,email,' . $user->user_id,
            'phone_number' => 'nullable|digits_between:10,15',
            'address' => 'nullable|max:255',
        ]);

        // Nếu kiểm tra dữ liệu không hợp lệ, trả về lỗi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cập nhật dữ liệu người dùng
        $user->update($request->only('username', 'email', 'phone_number', 'address', 'role_id'));

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Trả về thông báo thành công và thông tin người dùng đã cập nhật
        return response()->json(['message' => 'Cập nhật người dùng thành công', 'user' => $user]);
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
