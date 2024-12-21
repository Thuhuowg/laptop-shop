<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
class CategoryController extends Controller
{
    //admin
    // public function AuthLogin(){
    //     $admin_id = Session::get('admin_id');
    //     if($admin_id){
    //         return Redirect::to('/dashboard');
    //     }else{
    //         return Redirect::to('/admin')->send();
    //     }
    // }

   

    public function all_category_product(){
        //$this->AuthLogin();
        $categories = CategoryModel::all();
        return response()->json(['data' => $categories]);
    }

    public function save_category_product(Request $request){
        $request->validate([
            'category_product_name' => 'required|string|max:255',
            'category_product_desc' => 'nullable|string',
            'category_product_status' => 'required|integer|in:0,1',
        ]);

        $category = CategoryModel::create([
            'category_name' => $request->input('category_product_name'),
            'category_desc' => $request->input('category_product_desc'),
            'category_status' => (int)$request->input('category_product_status'), 
        ]);
        dd($category);
        return response()->json(['data' => $category], 201);
    }

    public function unactive_category_product($category_product_id){
        //$this->AuthLogin();
        CategoryModel::where('category_id', $category_product_id)->update(['category_status' => 0]);
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        //$this->AuthLogin();
        CategoryModel::where('category_id', $category_product_id)->update(['category_status' => 1]);
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        //$this->AuthLogin();
        $edit_category_product = CategoryModel::findOrFail($category_product_id);
        return response()->json(['data' => $edit_category_product]);
    }

    public function update_category_product(Request $request,$category_product_id){
        $request->validate([
            'category_product_name' => 'required|string|max:255',
            'category_product_desc' => 'nullable|string',
        ]);
        $category = CategoryModel::findOrFail($category_product_id);
        
        $category->update([
            'category_name' => $request->input('category_product_name'),
            'category_desc' => $request->input('category_product_desc'),
        ]);
        $category->save();
        return response()->json(['data' => $category, 'redirect' => route('all-category')],200);
    }

    public function delete_category_product($category_product_id){
        $category = CategoryModel::findOrFail($category_product_id);
        $category->delete();
        return response()->json(['data' => $category],200);
    }

    //end admin
    public function show_category_home($category_id){

        $cate_product = DB::table('categories')->where('category_status', 1)->orderby('category_id','asc')->get(); 
        
        $brand_product = DB::table('tbl_brand')->where('brand_status', 1)->orderby('brand_id','asc')->get();

        $category_name = DB::table('categories')->where('categories.category_id',$category_id)->limit(1)->get();

        $category_by_id = DB::table('tbl_product')
        ->join('categories','tbl_product.category_id','=','categories.category_id')
        ->where('product_status',1)
        ->where('tbl_product.category_id',$category_id)->get();
        return view('layout.web.category.show_category')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('category_by_id',$category_by_id)
            ->with('category_name',$category_name);
    }

    public function get_category(){
        $categories = CategoryModel::where('status', 1)
                    ->orderBy('name', 'asc')
                    ->get();
        return response()->json($categories);
    }

}
