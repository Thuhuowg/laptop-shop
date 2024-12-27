<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::get('/user-id', function (Request $request) {
    $email = trim($request->query('email'));  // Lọc email để loại bỏ khoảng trắng

    // Kiểm tra xem email có tồn tại trong bảng user_pj hay không
    $user = User::where('email', $email)->first();

    if ($user) {
        // Trả về user_id nếu tìm thấy
        return response()->json(['user_id' => $user->user_id]);
    }

    // Nếu không tìm thấy user, trả về lỗi 404
    return response()->json(['error' => 'User not found'], 404);
});
Route::get('/userdetial', function (Request $request) {
    $userId = $request->query('user_id'); // Lấy user_id từ query string

    // Kiểm tra xem user_id có tồn tại trong bảng users không
    $user = User::where('user_id', $userId)->first();

    if ($user) {
        // Trả về thông tin người dùng nếu tìm thấy
        return response()->json([
            'message' => 'User found',
            'status' => 'success',
            'data' => [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,  // Thêm số điện thoại
                'address' => $user->address,            // Thêm địa chỉ
                'created_at' => $user->created_at,
                // Thêm các trường khác nếu cần
            ]
        ]);
    }

    // Nếu không tìm thấy user, trả về lỗi
    return response()->json([
        'message' => 'User not found',
        'status' => 'error',
        'data' => null
    ], 404);
});