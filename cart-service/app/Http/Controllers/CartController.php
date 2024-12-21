<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Lấy danh sách giỏ hàng của người dùng
    public function index()
    {
        $userId = 1; // Sử dụng user_id mặc định (hoặc bạn có thể thay thế bằng giá trị phù hợp)

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

        $userId = 1; // Sử dụng user_id mặc định

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

        $userId = 1; // Sử dụng user_id mặc định

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
        $userId = 1; // Sử dụng user_id mặc định

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
        $userId = 1; // Sử dụng user_id mặc định
        CartItem::where('user_id', $userId)->update(['is_deleted' => true]);

        return response()->json(['message' => 'Cart cleared.'], 200);
    }
}
