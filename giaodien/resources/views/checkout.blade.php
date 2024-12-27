@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Checkout | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<div class="container">
    <h2 class="title text-center">Thông Tin Thanh Toán</h2>
    <form id="checkout-form">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Địa Chỉ:</label>
            <input type="text" id="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Số Điện Thoại:</label>
            <input type="text" id="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="payment-method">Phương Thức Thanh Toán:</label>
            <select id="payment-method" class="form-control" required>
                <option value="">-- Chọn phương thức thanh toán --</option>
                <option value="COD">Thanh Toán Khi Nhận Hàng</option>
                <option value="VNPay">Thanh Toán VNPay</option>
            </select>
        </div>
        <div class="form-group">
            <label for="total-amount">Tổng Số Tiền:</label>
            <p id="total-amount" class="form-control-static"></p>
        </div>
        <div id="message" class="text-danger mt-3"></div>
        <button type="submit" class="btn btn-primary">Tạo Đơn Hàng</button>
    </form>
    <div id="payment-options" style="display:none;">
        <button type="button" id="vnpay-btn" class="btn btn-secondary btn-sm">
            <img src="/fontend/images/vnpay-logo.png" alt="VNPay" style="width: 20px; height: auto; margin-right: 5px;">
            Thanh toán VNPay
        </button>
        <button type="button" id="cod-btn" class="btn btn-secondary btn-sm">
            Thanh toán COD
        </button>
    </div>
</div>
@endsection
