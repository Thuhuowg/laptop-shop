<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGatewayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('gateway')->group(function () {
    // Định nghĩa route cho API Gateway
    Route::any('{service}/{endpoint}', [ApiGatewayController::class, 'forwardRequest'])
        ->where(['service' => 'user|product', 'endpoint' => 'login|register|list|details']);
});
