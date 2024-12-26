@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Checkout | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<div class="container">
    <h2 class="title text-center">Thông Tin Thanh Toán</h2>
    <form id="checkout-form">
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
                <option value="cash">Thanh Toán Khi Nhận Hàng</option>
                <option value="vnpay">Thanh Toán VNPay</option>
            </select>
        </div>
        <div class="form-group">
            <label for="total-amount">Tổng Số Tiền:</label>
            <p id="total-amount" class="form-control-static"></p>
        </div>
    </form>
    <form id="payment-form">
        <div class="form-group">
            <label for="amount">Nhập đúng số tiền cần thanh toán:</label>
            <input type="number" id="amount" name="amount" class="form-control" placeholder="Số tiền (VND)" required>
        </div>
        <button type="button" id="vnpay-btn" class="btn btn-secondary btn-sm" style="display:none;">
            <img src="/fontend/images/vnpay-logo.png" alt="VNPay" style="width: 20px; height: auto; margin-right: 5px;">
            Thanh toán VNPay
        </button>
        <button type="button" id="cod-btn" class="btn btn-secondary btn-sm" style="display:none;">
            Thanh toán COD
        </button>
        <div id="message" class="text-danger mt-3"></div>
    </form>
</div>

@endsection