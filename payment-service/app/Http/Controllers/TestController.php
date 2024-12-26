<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function payment(Request $request)
    {
        // Thông tin cấu hình VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8002/thankyou"; // Địa chỉ trả về sau khi thanh toán
        $vnp_TmnCode = "LNYT5TSP"; // Mã website tại VNPAY 
        $vnp_HashSecret = "ZBUPSXKHMI3CUXLWM7Y7GKYW8PP8A4SN"; // Chuỗi bí mật
        
        // Tạo mã đơn hàng ngẫu nhiên
        $vnp_TxnRef = rand(100000, 999999); 
        
        // Thông tin đơn hàng
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') *100; // Số tiền (VND)
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->input('bank_code', 'NCB'); // Mã ngân hàng, mặc định là NCB
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        // Thông tin khách hàng
        $fullName = $request->input('fullName');
        $address = $request->input('address');
        $phone = $request->input('phone');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );

        // Thêm mã ngân hàng nếu có
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp dữ liệu theo thứ tự
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= ($i == 0 ? '' : '&') . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
            $i++;
        }

        // Tạo URL
        $vnp_Url .= "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Trả về kết quả
        return response()->json(['code' => '00', 'message' => 'success', 'data' => $vnp_Url]);
    }

    public function return(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_Amount = $request->input('vnp_Amount') / 100; // Chuyển đổi về tiền gốc

        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            return "Thanh toán thành công! Mã đơn hàng: $vnp_TxnRef, Số tiền: $vnp_Amount VND";
        } else {
            // Thanh toán thất bại
            return "Thanh toán thất bại! Mã đơn hàng: $vnp_TxnRef, Mã lỗi: $vnp_ResponseCode";
        }
    }
}