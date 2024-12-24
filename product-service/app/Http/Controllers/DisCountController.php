<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::where('is_deleted', 0)->get();
        return response()->json($discounts);
    }

    public function show($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }
        return response()->json($discount);
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount_name' => 'required|string|max:255',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $discount = Discount::create($request->all());
        return response()->json($discount, 201);
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $request->validate([
            'discount_name' => 'sometimes|required|string|max:255',
            'discount_percent' => 'sometimes|required|numeric|min:0|max:100',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
        ]);

        $discount->update($request->all());
        return response()->json($discount);
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $discount->update(['is_deleted' => 1]);
        return response()->json(['message' => 'Discount deleted']);
    }
}
