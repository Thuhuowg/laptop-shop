<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class return_payment extends Controller
{
    public function return_payment(Request $request)
    {
        // Lấy số tiền từ yêu cầu
        $amount = $request->input('amount');
        if (!$amount) {
            return response()->json(['code' => '01', 'message' => 'Số tiền không hợp lệ']);
        }

        // Gọi API POST đến VNPay
        $response = Http::post('http://localhost:8003/api/payment', [
            'amount' => $amount, // Truyền số tiền
            'method' => 'vnpay' // Phương thức thanh toán
        ]);

        // Trả về kết quả
        return response()->json($response->json());
    }
}

