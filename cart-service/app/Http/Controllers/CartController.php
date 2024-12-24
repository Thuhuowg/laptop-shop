<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    // Lấy user_id từ người dùng đã đăng nhập qua token JWT
    private function getUserId(Request $request)
    {
        try {
            // Giải mã token JWT và lấy thông tin người dùng
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return null;
            }

            return $user->id;
        } catch (JWTException $e) {
            return null;
        }
    }

    // Lấy danh sách giỏ hàng của người dùng
    public function getCart(Request $request)
    {
        $userId = $this->getUserId($request); // Lấy user_id từ người dùng đã đăng nhập

        if (is_null($userId)) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $cartItems = CartItem::where('user_id', $userId)  // Dùng user_id để tìm các item trong giỏ hàng
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

        $userId = $this->getUserId($request); // Lấy user_id từ người dùng đã đăng nhập qua token JWT
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

        $userId = $this->getUserId($request); // Lấy user_id từ người dùng đã đăng nhập qua token JWT
        if (is_null($userId)) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json($cartItem, 200);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy(Request $request, $id)
    {
        $userId = $this->getUserId($request); // Lấy user_id từ người dùng đã đăng nhập qua token JWT
        if (is_null($userId)) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['is_deleted' => true]);

        return response()->json(['message' => 'Item removed from cart.'], 200);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clear(Request $request)
    {
        $userId = $this->getUserId($request); // Lấy user_id từ người dùng đã đăng nhập qua token JWT
        if (is_null($userId)) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        CartItem::where('user_id', $userId)->update(['is_deleted' => true]);

        return response()->json(['message' => 'Cart cleared.'], 200);
    }
}
