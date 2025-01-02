<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Trả về user_id cố định là 10
    private function getUserId(Request $request)
    {
        return 10;
    }

    // Hàm gọi API để lấy thông tin sản phẩm từ ProductService
    private function fetchProductDetails($productIds)
{
    $productDetails = [];

    foreach ($productIds as $productId) {
        $response = Http::get("http://127.0.0.1:8000/api/v1/products/{$productId}");

        if ($response->successful()) {
            $productDetails[] = $response->json()['data'] ?? [];
        } else {
            Log::warning("Failed to fetch product details for product_id: {$productId}", [
                'response' => $response->body()
            ]);
        }
    }

    return $productDetails;
}

    // Lấy danh sách giỏ hàng của người dùng
    public function getCart(Request $request)
    {
        $userId = $this->getUserId($request);

        $cartItems = CartItem::where('user_id', $userId)
            ->where('is_deleted', false)
            ->get();

        // Lấy danh sách product_id từ giỏ hàng
        $productIds = $cartItems->pluck('product_id')->toArray();

        // Gọi API để lấy thông tin sản phẩm
        $productDetails = $this->fetchProductDetails($productIds);

        // Tạo map product_id => product
        $productMap = collect($productDetails)->keyBy('product_id');

        // Bổ sung thông tin sản phẩm vào dữ liệu giỏ hàng
        $cartData = $cartItems->map(function ($item) use ($productMap) {
            $product = $productMap->get($item->product_id, []);
            return [
                'cart_id' => $item->cart_id,
                'quantity' => $item->quantity,
                'product_id' => $item->product_id,
                'product_name' => $product['product_name'] ?? 'Unknown',
                'image_url' => $product['image_url'] ?? '', 
                'price' => $product['price'] ?? 0,
                'discount' => $product['discount'] ?? '',
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Cart fetched successfully',
            'data' => $cartData,
        ], 200);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $this->getUserId($request);

        $existingItem = CartItem::where('user_id', $userId)
            ->where('product_id', $validated['product_id'])
            ->where('is_deleted', false)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $validated['quantity'];
            $existingItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Cart item updated successfully',
                'data' => $existingItem,
            ], 200);
        }

        $cartItem = CartItem::create([
            'user_id' => $userId,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully',
            'data' => $cartItem,
        ], 201);
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $this->getUserId($request);

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'status' => true,
            'message' => 'Cart item updated successfully',
            'data' => $cartItem,
        ], 200);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy(Request $request, $id)
    {
        $userId = $this->getUserId($request);

        $cartItem = CartItem::where('cart_id', $id)
            ->where('user_id', $userId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $cartItem->update(['is_deleted' => true]);

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart.',
            'data' => null,
        ], 200);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clear(Request $request)
    {
        $userId = $this->getUserId($request);

        CartItem::where('user_id', $userId)->update(['is_deleted' => true]);

        return response()->json([
            'status' => true,
            'message' => 'Cart cleared.',
            'data' => null,
        ], 200);
    }
}
