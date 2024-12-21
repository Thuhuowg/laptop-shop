<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DiscountModel;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use DB;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    //admin
    // public function AuthLogin(){
    //     $admin_id = Session::get('admin_id');
    //     if($admin_id){
    //         return Redirect::to('dashboard');
    //     }else{
    //         return Redirect::to('admin')->send();
    //     }
    // }
    
    public function add_product(){
        //$this->AuthLogin();
        $cate_product = CategoryModel::orderBy('category_name', 'asc')->get();
        $discounts = DiscountModel::orderBy('discount_name', 'asc')->get();
        return response()->json([
            'cate_product' => $cate_product,
            'discounts' => $discounts,
        ]);
    }
    public function all_product(){
        //$this->AuthLogin();
    	$all_product = ProductModel::with(['category', 'discount'])->get();
        return response()->json(['data' => $all_product]);
    }

    public function save_product(Request $request){
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories',
            'discount_id' => 'required|integer|exists:discounts',
            'product_desc' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image',
            'product_status' => 'required|integer|in:0,1',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imagePath = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/product'), $imagePath);
        }

        $product = ProductModel::create([
            'product_name' => $request->input('product_name'),
            'category_id' => $request->input('product_cate'),
            'discount_id' => $request->input('discount_id'),
            'product_desc' => $request->input('product_desc'),
            'product_price' => $request->input('product_price'),
            'product_image' => $imagePath,
            'product_status' => (int)$request->input('product_status'),
        ]);

        return response()->json(['data' => $product], 201);
    }
    public function unactive_product($product_id){
        //$this->AuthLogin();
        ProductModel::where('product_id', $product_id)->update(['product_status' => 0]);
        return Redirect::to('all-product');
    }
    public function active_product($product_id){
        //$this->AuthLogin();
        ProductModel::where('product_id', $product_id)->update(['product_status' => 1]);
        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
        //$this->AuthLogin();
        $edit_product = ProductModel::with(['category', 'discount'])->find($product_id);
        return response()->json(['data' => $edit_product]);

    }

    public function update_product(Request $request,$product_id){
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories',
            'discount_id' => 'required|integer|exists:discounts',
            'product_desc' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imagePath = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/product'), $imagePath);
        }

        $product = ProductModel::findOrFail($product_id);

        $product ->update([
            'product_name' => $request->input('product_name'),
            'category_id' => $request->input('product_cate'),
            'discount_id' => $request->input('discount_id'),
            'product_desc' => $request->input('product_desc'),
            'product_price' => $request->input('product_price'),
            'product_image' => $imagePath,
        ]);

        return response()->json(['data' => $product, 'redirect' => ('/all-product')], 200);
    }

    public function delete_product($product_id){
        //$this->AuthLogin();
        $product = ProductModel::findOrFail($product_id);
        $product->delete();
        return response()->json(['data' => $product],200);
    }

    //end admin

    public function details_product($product_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id','asc')->get(); 
        
        $brand_product = DB::table('tbl_brand')->where('brand_status', 1)->orderby('brand_id','asc')->get();

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
        }
       
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)
        ->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('layout.web.product.show_details')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('product_details',$details_product)
            ->with('related',$related_product);
    }
}
