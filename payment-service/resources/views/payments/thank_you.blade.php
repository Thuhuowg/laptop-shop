<!-- resources/views/payments/show.blade.php -->
@extends('layouts.layout')

@section('content')
    <!-- resources/views/payments/thank_you.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Cảm ơn bạn đã thực hiện thanh toán!</h1>
        <p>Chúng tôi đã nhận được thanh toán của bạn. Bạn sẽ nhận được email xác nhận trong thời gian sớm nhất.</p>
        <a href="{{ route('payments.index') }}">Quay lại trang chủ</a>
    </div>
</body>
</html>

@endsection
