<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    // Hiển thị tất cả đơn hàng
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => true,
            'message' => 'Danh sách đơn hàng',
            'data' => $orders
        ]);
    }

    // Lấy đơn hàng theo ID
    public function getOrderById($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng không tồn tại.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng tìm thấy.',
            'data' => $order
        ], 200);
    }

    // Lấy đơn hàng theo ID người dùng
    public function getOrdersByUserId($userId)
    {
        $orders = Order::where('user_id', $userId)->get();
        return response()->json([
            'status' => true,
            'message' => 'Danh sách đơn hàng của người dùng',
            'data' => $orders
        ]);
    }

    // Tạo đơn hàng mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu gửi lên
        $request->validate([
            'email' => 'required|email',  // Kiểm tra email hợp lệ
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string|max:20',
            'total_amount' => 'required|numeric',
            'status' => 'nullable|string|in:pending,completed,cancelled',
        ]);

        // Gọi API để lấy user_id từ email
        $response = Http::get('http://localhost:8001/api/user-id', ['email' => $request->email]);

        if ($response->failed()) {
            // Nếu không tìm thấy user_id, trả về lỗi
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.',
                'data' => null
            ], 404);
        }

        // Lấy user_id từ response
        $userId = $response->json()['user_id'];

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $userId,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'payment_method' => $request->payment_method,
            'total_amount' => (float)$request->total_amount,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng được tạo thành công',
            'data' => $order
        ], 201);
    }

    // Cập nhật thông tin đơn hàng
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng không tồn tại.',
                'data' => null
            ], 404);
        }

        $order->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng cập nhật thành công.',
            'data' => $order
        ]);
    }

    // Xóa đơn hàng
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng không tồn tại.',
                'data' => null
            ], 404);
        }

        $order->delete();
        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng đã được xóa.',
            'data' => null
        ]);
    }
}
