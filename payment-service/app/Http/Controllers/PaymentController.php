<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Lưu thanh toán mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu từ form
        $data = $request->validate([
            'order_id' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
            'amount' => 'required|numeric',
        ]);

        // Tạo thanh toán mới và lưu vào cơ sở dữ liệu
        $payment = Payment::create($data);

        // Trả về thông tin thanh toán vừa lưu
        return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], 201);
    }

    // Xử lý thanh toán online
    public function online_checkout(Request $request)
    {
        // Xác thực dữ liệu từ client
        $request->validate([
            'order_id' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'amount' => 'required|numeric',
        ]);

        $paymentMethod = $request->input('payment_method');
        $orderId = $request->input('order_id');
        $amount = $request->input('amount'); // Lấy số tiền từ request

        if ($paymentMethod == 'cash') {
            // Thanh toán COD
            return response()->json(['message' => 'Thanh toán COD', 'order_id' => $orderId]);
        } elseif ($paymentMethod == 'momo') {
            // Thanh toán qua MoMo
            return $this->processMomoPayment($orderId, $amount);
        } elseif ($paymentMethod == 'vnpay') {
            // Thanh toán qua VNPay
            return $this->processVnPayPayment($orderId, $amount);
        }

        return response()->json(['error' => 'Invalid payment method'], 400);
    }

    // Xử lý thanh toán qua MoMo
    private function processMomoPayment($orderId, $amount)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $redirectUrl = route('thank-you');
        $ipnUrl = route('thank-you');
        $extraData = "";
        $requestId = time() . "";

        // Tạo chuỗi rawHash để ký
        $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType=payWithATM";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => "payWithATM",
            'signature' => $signature,
        ];

        // Gửi yêu cầu và nhận phản hồi từ MoMo
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        // Kiểm tra phản hồi JSON
        if ($jsonResult === null) {
            return response()->json(['error' => 'Invalid JSON response'], 500);
        }

        if (isset($jsonResult['payUrl'])) {
            return response()->json(['payUrl' => $jsonResult['payUrl']]);
        }

        return response()->json(['error' => 'Error from MoMo'], 500);
    }

    // Xử lý thanh toán qua VNPay
    private function processVnPayPayment($orderId, $amount)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('thank-you');
        $vnp_TmnCode = "LNYT5TSP"; // Mã website tại VNPAY
        $vnp_HashSecret = "ZBUPSXKHMI3CUXLWM7Y7GKYW8PP8A4SN"; // Chuỗi bí mật

        $vnp_TxnRef = $orderId; // Sử dụng mã đơn hàng từ client
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_Amount = $amount * 100; // VNPay yêu cầu số tiền tính bằng đồng
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= $i ? '&' : '';
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
            $i = 1;
        }

        $vnp_Url .= "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return response()->json(['vnp_Url' => $vnp_Url]);
    }

    // Hàm gửi yêu cầu POST cho MoMo
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => 'cURL error: ' . curl_error($ch)], 500);
        }
        curl_close($ch);

        return $result;
    }
}