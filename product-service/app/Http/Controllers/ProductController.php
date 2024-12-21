<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'discount'])->where('is_deleted', 0)->get();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'discount'])->where('product_id', $id)->where('is_deleted', 0)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'product_name' => 'sometimes|required|string|max:50',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,category_id',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'image_url' => 'nullable|string|max:255',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['is_deleted' => 1]);
        return response()->json(['message' => 'Product deleted']);
    }
}
