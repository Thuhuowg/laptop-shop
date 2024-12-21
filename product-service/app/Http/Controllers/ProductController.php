<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm chưa xóa, kèm theo danh mục và giảm giá
        $products = Product::with(['category', 'discount'])->where('is_deleted', 0)->get();
        return response()->json($products);
    }

    public function show($id)
{
    // Tìm sản phẩm theo product_id (kiểu VARCHAR) và check is_deleted
    $product = Product::with(['category', 'discount'])
                      ->where('product_id', $id)  // Kiểm tra product_id
                      ->where('is_deleted', 0)    // Kiểm tra sản phẩm chưa bị xóa
                      ->first();

    // Nếu không tìm thấy sản phẩm
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Trả về thông tin sản phẩm
    return response()->json($product);
}


    public function store(Request $request)
    {
        // Xác nhận đầu vào của người dùng khi thêm sản phẩm mới
        $request->validate([
            'product_name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
        ]);

        // Tạo mới sản phẩm
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        // Tìm sản phẩm theo product_id (kiểu VARCHAR)
        $product = Product::where('product_id', $id)->where('is_deleted', 0)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Xác nhận đầu vào của người dùng khi cập nhật sản phẩm
        $request->validate([
            'product_name' => 'sometimes|required|string|max:50',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
        ]);

        // Cập nhật thông tin sản phẩm
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        // Tìm sản phẩm theo product_id (kiểu VARCHAR)
        $product = Product::where('product_id', $id)->where('is_deleted', 0)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Đánh dấu sản phẩm là đã xóa
        $product->update(['is_deleted' => 1]);
        return response()->json(['message' => 'Product deleted']);
    }
}
