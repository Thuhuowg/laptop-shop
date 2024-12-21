<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Order;
use App\Models\OrderItem;



class OrderController extends Controller
{
    // Sử dụng middleware auth:api để yêu cầu xác thực JWT
    // public function __construct()
    // {
    //     $this->middleware('auth:api')->except(['index', 'show']);  // Ví dụ: Để công khai index và show, còn lại cần xác thực
    // }

    // Xem danh sách đơn hàng
    public function index()
    {
        $orders = DB::table('Orders')
                    ->join('users', 'Orders.user_id', '=', 'users.user_id')
                    ->select('Orders.*', 'users.username as user_name')
                    ->get();

        // Đưa ra danh sách đơn hàng với thông tin người dùng
        return response()->json($orders);
    }

    // Xem chi tiết đơn hàng
    public function show($orderId)
    {
        $order = DB::table('Orders')
                    ->join('users', 'Orders.user_id', '=', 'users.user_id')
                    ->where('Orders.order_id', $orderId)
                    ->select('Orders.*', 'users.username as user_name')
                    ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Lấy các order items
        $orderItems = DB::table('Order_Items')
                        ->where('Order_Items.order_id', $orderId)
                        ->get();

        $order->order_items = $orderItems;

        return response()->json($order);
    }

    // Tạo đơn hàng mới
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'order_date' => 'required|date',
            'status' => 'required|string',
            'total_amount' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_name' => 'required|string',
            'order_items.*.quantity' => 'required|integer',
            'order_items.*.price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();

        try {
            // $user = JWTAuth::user(); 
            // if (!$user) {
            //     return response()->json(['message' => 'Unauthorized'], 401); // Nếu không tìm thấy user
            // }
            // Tạo đơn hàng
            $orderId = DB::table('Orders')->insertGetId([
                'user_id' => $request->user_id,
                'order_date' => $request->order_date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Thêm các item vào đơn hàng
            foreach ($request->order_items as $item) {
                DB::table('Order_Items')->insert([
                    'order_id' => $orderId,
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    // 'total_amount' => $item['quantity'] * $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Commit transaction
            DB::commit();

            return response()->json(['message' => 'Order created successfully', 'order_id' => $orderId], 201);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return response()->json(['message' => 'Error occurred while creating the order', 'error' => $e->getMessage()], 500);
        }
    }

    // Xoá đơn hàng
     public function destroy($orderId)
    {
        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            // Kiểm tra xem đơn hàng có tồn tại không
            $order = Order::where('order_id', $orderId);  // Tìm đơn hàng bằng order_id

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Xoá các item trong đơn hàng (soft delete)
            OrderItem::where('order_id', $orderId)->delete();  // Soft delete các item trong đơn hàng

            // Xoá đơn hàng (soft delete)
            $order->delete();  // Soft delete đơn hàng

            // Commit transaction
            DB::commit();

            return response()->json(['message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return response()->json(['message' => 'Error occurred while deleting the order', 'error' => $e->getMessage()], 500);
        }
    }
}