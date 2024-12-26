@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Home | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<body>
    <div id="header-container"></div>

    <div class="container">
        <h2 class="title text-center">Giỏ Hàng Của Bạn</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Đơn Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Sản phẩm sẽ được hiển thị ở đây -->
            </tbody>
        </table>
        <div class="text-right">
            <h3 id="cart-total">Tổng: 0 VNĐ</h3>
            <a href="/checkout">
                <button  class="btn btn-primary" id="checkout-button">Thanh Toán</button>
            </a>
        </div>
    </div>

    <div id="footer-container"></div>

    <script src="/fontend/js/cart.js"></script>
</body>
@endsection
