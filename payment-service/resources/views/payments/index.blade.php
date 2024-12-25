@extends('layouts.layout')

@section('content')
    <h1>Danh Sách Thanh Toán</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn hàng</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái thanh toán</th>
                <th>Tổng tiền</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->order_id }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>
                        @if ($payment->payment_status === 'success')
                            <span class="badge bg-success">Thành công</span>
                        @elseif ($payment->payment_status === 'pending')
                            <span class="badge bg-warning">Chờ xử lý</span>
                        @else
                            <span class="badge bg-danger">Thất bại</span>
                        @endif
                    </td>
                    <td>{{ number_format($payment->amount, 2) }} VND</td>
                    <td>
                        @if ($payment->payment_status === 'pending')
                            <div class="btn-group">
                                <!-- Chỉ hiển thị nút thanh toán MoMo nếu payment_method là momo -->
                                @if ($payment->payment_method === 'MoMo')
                                    <form action="{{ url('/api/payments/momo') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $payment->order_id }}">
                                        <input type="hidden" name="amount" value="{{ $payment->amount }}">
                                        <button type="submit" name='payUrl' class="btn btn-primary btn-sm">
                                            <img src="{{ asset('/fontend/images/momo-logo.png') }}" alt="MoMo" style="width: 20px; height: auto; margin-right: 5px;">
                                            Thanh toán MoMo
                                        </button>
                                    </form>
                                @endif

                                <!-- Chỉ hiển thị nút thanh toán VNPay nếu payment_method là vnpay -->
                                @if ($payment->payment_method === 'VNPay')
                                    <form action="{{ url('/api/payments/vnpay') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $payment->order_id }}">
                                        <input type="hidden" name="amount" value="{{ $payment->amount }}">
                                        <button type="submit" name="redirect" class="btn btn-secondary btn-sm">
                                            <img src="{{ asset('/fontend/images/vnpay-logo.png') }}" alt="VNPay" style="width: 20px; height: auto; margin-right: 5px;">
                                            Thanh toán VNPay
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <button class="btn btn-light btn-sm" disabled>Đã thanh toán</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
