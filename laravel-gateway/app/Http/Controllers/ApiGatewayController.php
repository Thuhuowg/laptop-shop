<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiGatewayController extends Controller
{
    public function forwardRequest($service, $endpoint, Request $request)
    {
        // Lấy URL của dịch vụ và endpoint
        $url = $this->getServiceUrl($service, $endpoint, $request);

        // Nếu không có URL hợp lệ, trả về lỗi
        if (!$url) {
            return response()->json(['error' => 'Dịch vụ hoặc endpoint không hợp lệ'], 400);
        }

        // Xử lý yêu cầu HTTP tùy thuộc vào phương thức (POST, GET, PUT, DELETE)
        $httpResponse = Http::withHeaders($request->headers->all())
            ->send($request->method(), $url, [
                'json' => $request->all()  // Nếu là POST/PUT, gửi dữ liệu JSON
            ]);

        // Trả lại phản hồi từ microservice cho client
        return response()->json($httpResponse->json(), $httpResponse->status());
    }

    private function getServiceUrl($service, $endpoint, Request $request)
    {
        // Cấu hình các URL của dịch vụ và endpoint
        $serviceUrls = [
            'user' => [
                'login' => 'http://127.0.0.1:8002/api/auth/login',
                'register' => 'http://127.0.0.1:8002/api/auth/register',
            ],
            'product' => [
                'list' => 'http://product-service.local/api/products',
                'details' => 'http://product-service.local/api/products/{id}',
            ],
            // Thêm các dịch vụ khác nếu cần
        ];

        // Kiểm tra nếu dịch vụ và endpoint tồn tại trong mảng cấu hình
        if (isset($serviceUrls[$service][$endpoint])) {
            $url = $serviceUrls[$service][$endpoint];

            // Nếu endpoint có tham số động (ví dụ: {id}), thay thế bằng giá trị thực tế
            if (strpos($url, '{id}') !== false && $request->route('id')) {
                // Thay thế {id} bằng giá trị tham số 'id' từ URL
                $url = str_replace('{id}', $request->route('id'), $url);
            }

            return $url;
        }

        // Trả về chuỗi rỗng nếu không tìm thấy dịch vụ hoặc endpoint hợp lệ
        return '';
    }
}
