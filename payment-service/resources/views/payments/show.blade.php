<!-- resources/views/payments/show.blade.php -->
@extends('layouts.layout')

@section('content')
    <h1>Chi Tiết Thanh Toán</h1>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $payment->id }}</td>
        </tr>
        <tr>
            <th>Order ID</th>
            <td>{{ $payment->order_id }}</td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td>{{ $payment->payment_method }}</td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td>{{ $payment->payment_status }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $payment->amount }}</td>
        </tr>
    </table>
    <a href="{{ url('/payments') }}" class="btn btn-primary">Trở lại danh sách</a>
@endsection
