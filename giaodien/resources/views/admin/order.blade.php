<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .navbar {
            background-color: rgb(229, 149, 2);
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .content {
            transition: margin-left 0.3s ease;
        }

        .content.shift {
            margin-left: 250px;
        }

        .menu-btn {
            border: none;
            background: transparent;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h5 class="text-center mb-3">Menu</h5>
        <nav class="nav flex-column">
            <a class="nav-link" href="{{URL::to('/adusers')}}">Quản lý người dùng</a>
            <a class="nav-link" href="{{URL::to('/adproduct')}}">Quản lý sản phẩm</a>
            <a class="nav-link active" href="{{URL::to('/adcategory')}}">Quản lý danh mục</a>
            <a class="nav-link" href="{{URL::to('/addiscount')}}">Quản lý giảm giá</a>
            <a class="nav-link" href="{{URL::to('/adorder')}}">Quản lý đơn hàng</a>
            <a class="nav-link" href="/login" style="margin-top: 500px; text-align: center;">Đăng Xuất</a>
        </nav>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="menu-btn" id="menuToggle">☰</button>
            <a class="navbar-brand" href="/adorder">Quản lý Đơn Hàng</a>
        </div>
    </nav>

    <div class="container mt-4 content" id="content">
        <section id="orderList">
            <h1>Danh sách Đơn Hàng</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addOrderModal">Thêm Đơn Hàng</button>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTable"></tbody>
            </table>
        </section>
    </div>

    <!-- Add Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrderModalLabel">Thêm Đơn Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addOrderForm">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Tên Khách Hàng</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Phương Thức Thanh Toán</label>
                            <input type="text" class="form-control" id="paymentMethod" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Tổng Tiền</label>
                            <input type="number" class="form-control" id="totalAmount" required>
                        </div>
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Trạng Thái</label>
                            <select class="form-select" id="orderStatus" required>
                                <option value="pending">Chờ xử lý</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary add-order">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Sửa Đơn Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderForm"></form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        document.getElementById('menuToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('open');
            content.classList.toggle('shift');
        });

        // Load orders
        function loadOrders() {
            $.ajax({
                url: "http://127.0.0.1:8004/api/orders",
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    const orders = $('#orderTable');
                    orders.empty();
                    data.data.forEach(function(order) {
                        const row = `
                            <tr id="order-${order.id}">
                                <td>${order.id}</td>
                                <td>${order.customer_name}</td>
                                <td>${order.address}</td>
                                <td>${order.phone}</td>
                                <td>${order.payment_method}</td>
                                <td>${order.total_amount}</td>
                                <td>${order.status}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-order" data-id="${order.id}">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-order" data-id="${order.id}">Xóa</button>
                                </td>
                            </tr>
                        `;
                        orders.append(row);
                    });
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        // Add order
        function addOrder(event) {
            event.preventDefault();
            const data = {
                customer_name: $('#customerName').val(),
                address: $('#address').val(),
                phone: $('#phone').val(),
                payment_method: $('#paymentMethod').val(),
                total_amount: $('#totalAmount').val(),
                status: $('#orderStatus').val(),
            };

            $.ajax({
                url: "http://127.0.0.1:8004/api/orders",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Đơn hàng mới đã được thêm thành công!');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Delete order
        function deleteOrder(orderId) {
            $.ajax({
                url: 'http://127.0.0.1:8004/api/orders/' + orderId,
                method: 'DELETE',
                contentType: 'application/json',
                success: function(response) {
                    alert('Xóa đơn hàng thành công!');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Edit order
        function editOrder(orderId) {
            $.ajax({
                url: 'http://127.0.0.1:8004/api/orders/' + orderId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    const editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
                    editOrderModal.show();
                    const orders = $('#editOrderForm');
                    const row = `
                        <div class="mb-3">
                            <label for="editCustomerName" class="form-label">Tên Khách Hàng</label>
                            <input type="text" class="form-control" id="editCustomerName" value="${data.data.customer_name}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Địa Chỉ</label>
                            <input type="text" class="form-control" id="editAddress" value="${data.data.address}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="editPhone" value="${data.data.phone}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPaymentMethod" class="form-label">Phương Thức Thanh Toán</label>
                            <input type="text" class="form-control" id="editPaymentMethod" value="${data.data.payment_method}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalAmount" class="form-label">Tổng Tiền</label>
                            <input type="number" class="form-control" id="editTotalAmount" value="${data.data.total_amount}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editOrderStatus" class="form-label">Trạng Thái</label>
                            <select class="form-select" id="editOrderStatus" required>
                                <option value="pending" ${data.data.status === 'pending' ? 'selected' : ''}>Chờ xử lý</option>
                                <option value="completed" ${data.data.status === 'completed' ? 'selected' : ''}>Hoàn thành</option>
                                <option value="cancelled" ${data.data.status === 'cancelled' ? 'selected' : ''}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary update-order" data-id="${data.data.id}">Lưu</button>
                    `;
                    orders.empty().append(row);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Update order
        function updateOrder(orderId) {
            const data = {
                customer_name: $('#editCustomerName').val(),
                address: $('#editAddress').val(),
                phone: $('#editPhone').val(),
                payment_method: $('#editPaymentMethod').val(),
                total_amount: $('#editTotalAmount').val(),
                status: $('#editOrderStatus').val(),
            };
            $.ajax({
                url: 'http://127.0.0.1:8004/api/orders/' + orderId,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Thông tin đơn hàng đã được lưu thành công!");
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            loadOrders();

            $(document).on('click', '.add-order', addOrder);

            $(document).on('click', '.delete-order', function(event) {
                event.preventDefault();
                var orderId = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
                    deleteOrder(orderId);
                }
            });

            $(document).on('click', '.edit-order', function(event) {
                event.preventDefault();
                var orderId = $(this).data('id');
                editOrder(orderId);
            });

            $(document).on('click', '.update-order', function(event) {
                event.preventDefault();
                var orderId = $(this).data('id');
                updateOrder(orderId);
            });
        });
    </script>
    
</body>

</html>