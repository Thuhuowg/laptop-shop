<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm chưa bị xóa
    public function index()
    {
        // Lấy danh sách sản phẩm chưa xóa, kèm theo danh mục và giảm giá
        $products = Product::with(['category', 'discount'])->where('is_deleted', 0)->get();
        return response()->json($products);
    }

    // Hiển thị thông tin chi tiết của một sản phẩm
    public function show($id)
    {
        // Tìm sản phẩm theo product_id (kiểu VARCHAR) và kiểm tra xem sản phẩm chưa bị xóa
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

    // Thêm mới một sản phẩm
    public function store(Request $request)
    {
        dd($request->all());
        // Xác nhận đầu vào của người dùng khi thêm sản phẩm mới
        $request->validate([
            'product_id' => 'required|string|max:100|unique:products,product_id', // product_id cần duy nhất
            'product_name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Tạo mới sản phẩm
        $product = Product::create([
            'product_id' => $request->input('product_id'),
            'product_name' => $request->input('product_name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
            'image_url' => $request->input('image_url'),
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
    public function destroy(string $id)
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
    public function filterProducts(Request $request)
    {
        $categoryIds = $request->input('category_id'); // Lấy category_id từ query string
        $priceRanges = $request->input('price_range'); // Lấy price_range từ query string (0-10, 10-20, ...)

        // Bắt đầu query sản phẩm
        $query = Product::query();

        // Lọc theo danh mục (nếu có)
        if ($categoryIds) {
            $categoryIdsArray = explode(',', $categoryIds);
            $query->whereIn('category_id', $categoryIdsArray);
        }

        // Lọc theo mức giá (nếu có)
        if ($priceRanges) {
            $priceRangesArray = explode(',', $priceRanges);
            $query->where(function ($q) use ($priceRangesArray) {
                foreach ($priceRangesArray as $range) {
                    list($minPrice, $maxPrice) = explode('-', $range);
                    $q->orWhere(function ($subQuery) use ($minPrice, $maxPrice) {
                        $subQuery->where('price', '>=', $minPrice * 1000000)
                            ->where('price', '<=', $maxPrice * 1000000);
                    });
                }
            });
        }

        // Lấy danh sách sản phẩm
        $products = $query->get();

        // Trả về JSON response
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
}
