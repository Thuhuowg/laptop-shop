@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Thankyou | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<div class="thank-you-container">
    <h1>Thank You for Your Purchase!</h1>
    <p>Your payment has been successfully processed.</p>
    <p>We appreciate your business and hope you enjoy your purchase.</p>
    <a href="/fe/home/home.html" class="button">Return to Home</a>
</div>
@endsection