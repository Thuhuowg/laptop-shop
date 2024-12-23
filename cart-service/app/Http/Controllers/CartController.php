<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Lấy danh sách giỏ hàng của người dùng
    public function index()
    {
        $userId = Auth::id(); // Lấy user_id từ người dùng đã đăng nhập
        dd($userId); // Kiểm tra xem có lấy được user_id không
        $cartItems = CartItem::where('user_id', $userId)
            ->where('is_deleted', false)
            ->get();

        return response()->json($cartItems, 200);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    $userId = Auth::id(); // Lấy user_id từ người dùng đã đăng nhập

    // Kiểm tra xem user_id có phải là null không
    if (is_null($userId)) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $existingItem = CartItem::where('user_id', $userId)
        ->where('product_id', $validated['product_id'])
        ->where('is_deleted', false)
        ->first();

    if ($existingItem) {
        $existingItem->quantity += $validated['quantity'];
        $existingItem->save();
        return response()->json($existingItem, 200);
    }

    $cartItem = CartItem::create([
        'user_id' => $userId,
        'product_id' => $validated['product_id'],
        'quantity' => $validated['quantity'],
    ]);

    return response()->json($cartItem, 201);
}

    // Cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); // Lấy user_id từ người dùng đã đăng nhập

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json($cartItem, 200);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        $userId = Auth::id(); // Lấy user_id từ người dùng đã đăng nhập

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['is_deleted' => true]);

        return response()->json(['message' => 'Item removed from cart.'], 200);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clear()
    {
        $userId = Auth::id(); // Lấy user_id từ người dùng đã đăng nhập
        CartItem::where('user_id', $userId)->update(['is_deleted' => true]);

        return response()->json(['message' => 'Cart cleared.'], 200);
    }
}