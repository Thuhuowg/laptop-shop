<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MomoPaymentController extends Controller
{
    // Xử lý thanh toán qua MoMo
    public function processMomoPayment(Request $request)
    {
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');

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