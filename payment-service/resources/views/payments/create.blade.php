<!-- resources/views/payments/create.blade.php -->
@extends('layouts.layout')

@section('content')
    <h1>Tạo Thanh Toán Mới</h1>
    <form action="{{ url('/payments') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="order_id">Mã đơn hàng</label>
            <input type="text" name="order_id" id="order_id" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="">Chọn phương thức thanh toán</option>
                <option value="VNPay">VNPay</option>
                <option value="ZaloPay">ZaloPay</option>
                <option value="QRCode">QR Code</option>
                <option value="COD">COD (Thanh toán khi nhận hàng)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="payment_status">Trạng thái thanh toán</label>
            <select name="payment_status" id="payment_status" class="form-control" required>
                <option value="">Chọn trạng thái thanh toán</option>
                <option value="pending">Chờ xử lý</option>
                <option value="success">Thành công</option>
                <option value="failed">Thất bại</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="amount">Tổng tiền</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-success">Tạo Thanh Toán</button>
    </form>
@endsection
