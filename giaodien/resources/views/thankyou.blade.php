@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Thankyou | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="background-blur"></div>
    <div class="thank-you-container text-center">
        <img src="/fontend/images/thankyou.png" alt="Thank You!!!" />
        <h1>Thanh toán thành công !</h1>
        <h4>Mong rằng sản phẩm và dịch vụ của shop sẽ làm bạn hài lòng.</h4>
        <h4>Nếu có điều gì cần cải thiện mong bạn góp ý.</h4>
        <h4>Cảm ơn vì đã cho shop có cơ hội phục vụ bạn.</h4>
        <h4>Nếu hài lòng đừng quên gửi ảnh Feedback để nhận ưu đãi từ shop nhé !!!</h4>
        <a href="/home" class="btn btn-primary">Return to Home</a>
    </div>
</div>
<script>localStorage.removeItem("cart")</Script>
@endsection