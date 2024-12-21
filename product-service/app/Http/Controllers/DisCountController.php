<?php

namespace App\Http\Controllers;

use App\Models\DiscountModel;
use Illuminate\Http\Request;

class DisCountController extends Controller
{
    

    public function all_discount(){
        //$this->AuthLogin();
        $discounts = DiscountModel::all();
    	return response()->json(['data' => $discounts]);
    }

    public function save_discount(Request $request){
        $request->validate([
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|string|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $discount = DiscountModel::create([
            'discount_name' => $request->discount_name,
            'discount_percent' => $request->discount_percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(['discount' => $discount,], 201);
    }

    public function edit_discount($discount_id){
        //$this->AuthLogin();
        $edit_discount = DiscountModel::findOrFail($discount_id);
        return response()->json(['data' => $edit_discount]);
    }

    public function update_discount(Request $request,$discount_id){
        $request->validate([
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|string|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $discount = DiscountModel::findOrFail($discount_id);
        
        $discount->update([
            'discount_name' => $request->discount_name,
            'discount_percent' => $request->discount_percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $discount->save();
        return response()->json(['data' => $discount, 'redirect' => route('all-discount')],200);
    }

    public function delete_discount($discount_id){
        $discount = DiscountModel::findOrFail($discount_id);
        $discount->delete();
        return response()->json(['data' => $discount],200);
    }
}
