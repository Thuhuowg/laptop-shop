<?php

// namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use App\Models\User;


// class UserController extends Controller
// {
//     // Danh sách người dùng
//     public function index()
//     {
//         $users = User::all(); // Lấy tất cả người dùng
//         return view('users.index', compact('users'));
//     }

//     // Hiển thị form tạo người dùng
//     public function create()
//     {
//         return view('users.create');
//     }

//     public function store(Request $request)
//     {
//         // Xác thực dữ liệu
//         $request->validate([
//             'username' => 'required|unique:user_pj|max:255',
//             'password' => 'required|min:6',
//             'email' => 'required|email|unique:user_pj,email',
//             'phone_number' => 'nullable|digits_between:10,15',
//             'address' => 'nullable|max:255',
//         ]);
//         try {
//             // Lưu vào cơ sở dữ liệu
//             User::create([
//                 'username' => $request->username,
//                 'password' => $request->password, // Không mã hóa
//                 'email' => $request->email,
//                 'phone_number' => $request->phone_number,
//                 'address' => $request->address,
//                 'role_id' => $request->role_id,
//             ]);

//             return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công!');
//         } catch (\Exception $e) {
//             return redirect()->back()->with('error', $e->getMessage());
//         }
//     }

//     public function edit($id)
//     {
//         $user = User::find($id); // Tìm người dùng theo id
//         if (!$user) {
//             return response()->json(['message' => 'Người dùng không tồn tại'], 404);
//         }

//         return response()->json($user); // Trả về thông tin người dùng dưới dạng JSON
//     }

//     // Cập nhật thông tin người dùng
//     public function update(Request $request, $id)
//     {
//         $user = User::findOrFail($id);

//         // Xác thực dữ liệu
//         $request->validate([
//             'username' => 'required|max:255|unique:user_pj,username,' . $id,
//             'email' => 'required|email|unique:user_pj,email,' . $id,
//             'phone_number' => 'nullable|digits_between:10,15',
//             'address' => 'nullable|max:255',
//         ]);

//         // Cập nhật dữ liệu
//         $user->update($request->only('username', 'email', 'phone_number', 'address', 'role_id'));

//         if ($request->filled('password')) {
//             $user->update(['password' => $request->password]);
//         }

//         return redirect()->route('users.index')->with('success', 'Thông tin người dùng đã được cập nhật!');
//     }

//     // Xóa người dùng trực tiếp
//     public function destroy($id)
//     {
//         $user = User::findOrFail($id);
//         $user->delete(); // Xóa trực tiếp khỏi cơ sở dữ liệu

//         return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa!');
//     }
// }
