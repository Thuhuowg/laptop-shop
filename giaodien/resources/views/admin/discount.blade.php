<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý giảm giá</title>
    <!-- Bootstrap CSS -->
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
    <!-- Sidebar Menu -->
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
            <a class="navbar-brand" href="/discount">Quản lý giảm giá</a>
        </div>
    </nav>

    <div class="container mt-4 content" id="content">
        <section id="discountList">
            <h1>Danh sách giảm giá</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDiscountModal">Thêm Giảm Giá</button>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Giảm Giá</th>
                        <th>Giá Trị (%)</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Ngày Kết Thúc</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="discountTable">
                    <!-- Dữ liệu sẽ được thêm vào đây -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Add Discount Modal -->
    <div class="modal fade" id="addDiscountModal" tabindex="-1" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDiscountModalLabel">Thêm Giảm Giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDiscountForm">
                        <div class="mb-3">
                            <label for="addDiscountName" class="form-label">Tên Giảm Giá</label>
                            <input type="text" class="form-control" id="addDiscountName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDiscountValue" class="form-label">Giá Trị Giảm Giá (%)</label>
                            <input type="number" class="form-control" id="addDiscountValue" required min="1" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Ngày Bắt Đầu</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Ngày Kết Thúc</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                        <button class="btn btn-primary add-discount">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Discount Modal -->
<div class="modal fade" id="editDiscountModal" tabindex="-1" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscountModalLabel">Sửa Giảm Giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDiscountForm">
                    
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- call api ajax -->
    <script type="text/javascript">
        //sự kiện click menu
        document.getElementById('menuToggle').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        // Toggle class 'open' cho sidebar
        sidebar.classList.toggle('open');
        // Toggle class 'shift' cho content
        content.classList.toggle('shift');
    });

        //hiển thị danh sách
        $.ajax({
            url: "http://127.0.0.1:8000/api/v1/discounts",
            type: "GET",
            dataType: 'json',
            success: function (data) {
                const discounts = $('#discountTable');
                discounts.empty(); 
                data.forEach(function(discount) {
                    const row = `
                        <tr id="discount-${discount.discount_id}">
                            <td>${discount.discount_id}</td>
                            <td>${discount.discount_name}</td>
                            <td>${discount.discount_percent}</td>
                            <td>${discount.start_date}</td>
                            <td>${discount.end_date}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-discount" data-id="${discount.discount_id}">Sửa</button>
                                <button class="btn btn-danger btn-sm delete-discount" data-id="${discount.discount_id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    discounts.append(row);
                    
                });
            },
            error: function (e) {
                console.log(xhr.responseText);
            }
        });

        //hàm thêm
        function addDiscount(){
            const data = {
                discount_name: $('#addDiscountName').val(),
                discount_percent: $('#addDiscountValue').val(),
                start_date: $('#startDate').val(),
                end_date: $('#endDate').val(),
            };

            $.ajax({
                url: "http://127.0.0.1:8000/api/v1/discounts",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Mã giảm giá mới đã được thêm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm xóa 
        function deleteDiscount(discountId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/discounts/' + discountId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    alert('Xóa mã giảm giá sản phẩm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm hiển thị form chỉnh sửa thông tin
        function editDiscount(discountId) {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/discounts/' + discountId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Hiện modal chỉnh sửa
                    const editdiscountModal = new bootstrap.Modal(document.getElementById('editDiscountModal'));
                    editdiscountModal.show();
                    const discounts = $('#editDiscountForm');
                    const start_date = data.start_date.split(' ')[0];
                    const end_date = data.end_date.split(' ')[0]; 
                    const row = `
                        <div class="mb-3">
                            <label for="editDiscountName" class="form-label">Tên Giảm Giá</label>
                            <input type="text" class="form-control" id="editDiscountName" value="${data.discount_name}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDiscountValue" class="form-label">Giá Trị Giảm Giá (%)</label>
                            <input type="number" class="form-control" id="editDiscountValue" value="${data.discount_percent}" required min="1" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="editStartDate" class="form-label">Ngày Bắt Đầu</label>
                            <input type="date" class="form-control" id="editStartDate" value="${start_date}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEndDate" class="form-label">Ngày Kết Thúc</label>
                            <input type="date" class="form-control" id="editEndDate" value="${end_date}" required>
                        </div>
                        <button class="btn btn-primary update-discount" data-id="${data.discount_id}">Lưu</button>
                    `;
                    discounts.empty().append(row);
                        

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm cập nhật 
        function updateDiscount(discountId) {
            const data = {
                discount_name: $('#editDiscountName').val(),
                discount_percent: $('#editDiscountValue').val(),
                start_date: $('#editStartDate').val(),
                end_date: $('#editEndDate').val(),
            };
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/discounts/'+ discountId,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Thông tin mã giảm được lưu giá thành công!");
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        

        $(document).ready(function() {
            //gọi hàm thêm danh mục
            $(document).on('click', '.add-discount', function(event) {
                event.preventDefault();
                addDiscount();
            });

            //gọi hàm xóa danh mục
            $(document).on('click', '.delete-discount', function(event) {
                event.preventDefault();
                
                var discountId = $(this).data('id');
                // Xác nhận trước khi xóa
                if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
                    deleteDiscount(discountId);
                }
            });

            //gọi hàm hiển thị form chỉnh sửa
            $(document).on('click', '.edit-discount', function(event) {
                event.preventDefault();
                
                var discountId = $(this).data('id');
                editDiscount(discountId);
            });

            //gọi hàm cập nhật danh mục
            $(document).on('click', '.update-discount', function(event) {
                event.preventDefault();
                
                var discountId = $(this).data('id');
                updateDiscount(discountId);
            });
            
        });
    </script>
    
</body>

</html>