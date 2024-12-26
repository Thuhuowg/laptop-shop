<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm chưa bị xóa
    public function index()
    {
        // Lấy danh sách sản phẩm chưa xóa, kèm theo danh mục và giảm giá
        $products = Product::with(['category', 'discount'])->where('is_deleted', 0)->orderBy('product_id', 'asc')->get();
        //lấy ra danh sách danh mục và giảm giá
        $categories = Category::orderBy('category_name', 'asc')->where('is_deleted', 0)->get();
        $discounts = Discount::orderBy('discount_name', 'asc')->where('is_deleted', 0)->get();
        return response()->json([
            'product' => $products,
            'category' => $categories,
            'discount' => $discounts,
        ]);
    }

    // Hiển thị thông tin chi tiết của một sản phẩm
    public function show($id)
    {
        // Tìm sản phẩm theo product_id (kiểu VARCHAR) và kiểm tra xem sản phẩm chưa bị xóa
        $products = Product::with(['category', 'discount'])
                          ->where('product_id', $id)  // Kiểm tra product_id
                          ->where('is_deleted', 0)    // Kiểm tra sản phẩm chưa bị xóa
                          ->first();

        // Nếu không tìm thấy sản phẩm
        if (!$products) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $categories = Category::orderBy('category_name', 'asc')->where('is_deleted', 0)->get();
        $discounts = Discount::orderBy('discount_name', 'asc')->where('is_deleted', 0)->get();
        // Trả về thông tin sản phẩm
        return response()->json([
            'product' => $products,
            'category' => $categories,
            'discount' => $discounts,
        ]);
    }

    // Thêm mới một sản phẩm
    public function store(Request $request)
    {   
        // Xác nhận đầu vào của người dùng khi thêm sản phẩm mới
        $request->validate([
            'product_name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
        ]);

        // Tạo mới sản phẩm
        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image_url' => $request->input('image_url'),
            'category_id' => $request->input('category_id'),
            'discount_id' => $request->input('discount_id'),
        ]);

        return response()->json($product, 201);
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, string $id)
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
            'description' => 'nullable|string',
        ]);

        // Cập nhật thông tin sản phẩm
        $product->update([
            'product_name' => $request->input('product_name', $product->product_name),
            'description' => $request->input('description', $product->description),
            'price' => $request->input('price', $product->price),
            'category_id' => $request->input('category_id', $product->category_id),
            'discount_id' => $request->input('discount_id', $product->discount_id),
            'image_url' => $request->input('image_url', $product->image_url),
        ]);

        return response()->json($product);
    }

    // Xóa một sản phẩm (soft delete)
    public function destroy( string $id)
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
