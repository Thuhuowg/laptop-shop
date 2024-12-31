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
        $products = Product::with(['category', 'discount'])
                           ->where('is_deleted', 0)
                           ->orderBy('product_id', 'asc')
                           ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products,
                'categories' => $this->getCategories(),
                'discounts' => $this->getDiscounts(),
            ],
        ]);
    }

    // Lấy thông tin một sản phẩm
    public function show($id)
    {
        $product = Product::with(['category', 'discount'])
                          ->where('product_id', $id)
                          ->where('is_deleted', 0)
                          ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }

    // Thêm mới một sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, string $id)
    {
        $product = Product::where('product_id', $id)->where('is_deleted', 0)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'product_name' => 'sometimes|required|string|max:50',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    // Xóa một sản phẩm (soft delete)
    public function destroy(string $id)
    {
        $product = Product::where('product_id', $id)->where('is_deleted', 0)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['is_deleted' => 1]);
        return response()->json(['message' => 'Product deleted']);
    }

    // Lấy danh mục
    private function getCategories()
    {
        return Category::where('is_deleted', 0)->orderBy('category_name', 'asc')->get();
    }

    // Lấy giảm giá
    private function getDiscounts()
    {
        return Discount::where('is_deleted', 0)->orderBy('discount_name', 'asc')->get();
    }

    // Lọc sản phẩm
    public function filterProducts(Request $request)
    {
        $query = Product::where('is_deleted', 0);
        
        if ($categoryIds = $request->input('category_id')) {
            $query->whereIn('category_id', explode(',', $categoryIds));
        }

        if ($priceRanges = $request->input('price_range')) {
            foreach (explode(',', $priceRanges) as $range) {
                [$minPrice, $maxPrice] = explode('-', $range);
                $query->orWhereBetween('price', [(int)$minPrice * 1000000, (int)$maxPrice * 1000000]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $query->get()]);
    }

    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with(['category', 'discount'])
                           ->where('product_name', 'LIKE', "%{$query}%")
                           ->where('is_deleted', 0)
                           ->get();

        return response()->json(['status' => 'success', 'data' => $products]);
    }
}