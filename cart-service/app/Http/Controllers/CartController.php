<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Lấy danh sách giỏ hàng của người dùng
    public function index(Request $request)
    {
        // Giả sử bạn đã đăng nhập và lấy user_id từ session hoặc token
        $userId = auth()->user()->id ?? 1; // Default user_id là 1 (hoặc có thể lấy từ session)

        $cartItems = CartItem::where('user_id', $userId)
            ->where('is_deleted', false)
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $existingItem = CartItem::where('user_id', $validated['user_id'])
            ->where('product_id', $validated['product_id'])
            ->where('is_deleted', false)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $validated['quantity'];
            $existingItem->save();
            return response()->json($existingItem, 200);
        }

        $cartItem = CartItem::create($validated);

        return response()->json($cartItem, 201);
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json($cartItem);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['is_deleted' => true]);

        return response()->json(['message' => 'Item removed from cart.']);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clear(Request $request)
    {
        $userId = $request->input('user_id');
        CartItem::where('user_id', $userId)->update(['is_deleted' => true]);

        return response()->json(['message' => 'Cart cleared.']);
    }
}
