@extends('layout.layout')

@section('title', 'Danh Sách Đơn Hàng | Laptop-Shoppe')

@section('content')
<div class="container">
    <h2 class="title text-center">Danh Sách Đơn Hàng Của Bạn</h2>
    
    <div id="orders-container">
        <div id="no-orders-message" class="text-center">Không có đơn hàng nào.</div>
        <table class="table table-bordered mt-3" id="orders-table" style="display: none;">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Phương Thức Thanh Toán</th>
                    <th>Tổng Số Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="orders-tbody">
                <!-- Các đơn hàng sẽ được hiển thị ở đây -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userId = localStorage.getItem('user_id');

        if (userId) {
            fetch(`http://localhost:8004/api/orders/user/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const ordersTbody = document.getElementById('orders-tbody');
                    const orders = data.data; // Đảm bảo lấy danh sách đơn hàng từ `data`

                    if (orders.length > 0) {
                        document.getElementById('no-orders-message').style.display = 'none';
                        document.getElementById('orders-table').style.display = 'table';

                        orders.forEach(order => {
                            const orderRow = document.createElement('tr');
                            orderRow.innerHTML = `
                                <td>${order.id}</td>
                                <td>${order.customer_name}</td>
                                <td>${order.address}</td>
                                <td>${order.phone}</td>
                                <td>${order.payment_method}</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(order.total_amount)} VNĐ</td>
                                <td>${order.status}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="cancelOrder(${order.id})">Hủy Đơn Hàng</button>
                                </td>
                            `;
                            ordersTbody.appendChild(orderRow);
                        });
                    } else {
                        document.getElementById('no-orders-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy đơn hàng:', error);
                    document.getElementById('orders-container').innerHTML = '<p class="text-danger">Lỗi khi tải đơn hàng. Vui lòng thử lại sau.</p>';
                });
        } else {
            document.getElementById('orders-container').innerHTML = '<p class="text-danger">Không tìm thấy thông tin người dùng.</p>';
        }
    });

    function cancelOrder(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            fetch(`http://localhost:8004/api/orders/${orderId}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    alert('Đơn hàng đã được hủy thành công!');
                    location.reload(); // Tải lại trang để cập nhật danh sách đơn hàng
                } else {
                    alert('Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Lỗi khi hủy đơn hàng:', error);
            });
        }
    }
</script>
@endsection
