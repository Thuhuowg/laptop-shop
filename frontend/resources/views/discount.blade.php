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
    <div class="sidebar" id="sidebar">
        <h5 class="text-center mb-3">Menu</h5>
        <nav class="nav flex-column">
            <a class="nav-link" href="/users">Quản lý người dùng</a>
            <a class="nav-link" href="/product">Quản lý sản phẩm</a>
            <a class="nav-link" href="/category">Quản lý danh mục</a>
            <a class="nav-link active" href="/discount">Quản lý giảm giá</a>
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
                        <button type="submit" class="btn btn-primary">Thêm</button>
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
                    <input type="hidden" id="editDiscountId">
                    <div class="mb-3">
                        <label for="editDiscountName" class="form-label">Tên Giảm Giá</label>
                        <input type="text" class="form-control" id="editDiscountName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDiscountValue" class="form-label">Giá Trị Giảm Giá (%)</label>
                        <input type="number" class="form-control" id="editDiscountValue" required min="1" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editStartDate" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="editStartDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEndDate" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="editEndDate" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function fetchDiscounts() {
            fetch('http://127.0.0.1:8000/api/v1/discounts')
                .then(response => response.json())
                .then(data => {
                    const discountTable = document.getElementById('discountTable');
                    let rows = '';
                    data.forEach(discount => {
                        rows += `
                            <tr id="discount-${discount.discount_id}">
                                <td>${discount.discount_id}</td>
                                <td>${discount.discount_name}</td>
                                <td>${discount.discount_percent}</td>
                                <td>${discount.start_date}</td>
                                <td>${discount.end_date}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editDiscount(${discount.discount_id})">Sửa</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteDiscount(${discount.discount_id})">Xóa</button>
                                </td>
                            </tr>
                        `;
                    });
                    discountTable.innerHTML = rows;
                })
                .catch(error => {
                    console.error('Error fetching discount data:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', fetchDiscounts);

        function deleteDiscount(id) {
            if (confirm('Bạn có chắc chắn muốn xóa giảm giá này?')) {
                fetch(`http://127.0.0.1:8000/api/v1/discounts/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error('Xóa không thành công');
                    const discountRow = document.getElementById(`discount-${id}`);
                    if (discountRow) discountRow.remove();
                    alert('Giảm giá đã được xóa thành công!');
                    fetchDiscounts();
                })
                .catch(error => {
                    console.error('Lỗi khi xóa giảm giá:', error);
                    alert('Không thể xóa giảm giá. Vui lòng thử lại!');
                });
            }
        }

        function editDiscount(id) {
            fetch(`http://127.0.0.1:8000/api/v1/discounts/${id}`)
                .then(response => response.json())
                .then(discount => {
                    if (discount.message) {
                        alert(discount.message);
                        return;
                    }
                    document.getElementById('editDiscountId').value = discount.discount_id;
                    document.getElementById('editDiscountName').value = discount.discount_name;
                    document.getElementById('editDiscountValue').value = discount.discount_percent;
                    document.getElementById('editStartDate').value = discount.start_date; // Ngày bắt đầu
                    document.getElementById('editEndDate').value = discount.end_date; // Ngày kết thúc

                    const editDiscountModal = new bootstrap.Modal(document.getElementById('editDiscountModal'));
                    editDiscountModal.show();
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thông tin giảm giá:', error);
                    alert('Không thể lấy thông tin giảm giá!');
                });
        }

        document.getElementById('editDiscountForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('editDiscountId').value;
            const updatedDiscount = {
                discount_name: document.getElementById('editDiscountName').value,
                discount_percent: document.getElementById('editDiscountValue').value,
            };
            fetch(`http://127.0.0.1:8000/api/v1/discounts/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(updatedDiscount),
            })
            .then(response => response.json())
            .then(updatedDiscount => {
                fetchDiscounts();
                alert('Giảm giá đã được cập nhật thành công!');
                const editDiscountModal = bootstrap.Modal.getInstance(document.getElementById('editDiscountModal'));
                editDiscountModal.hide();
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật giảm giá:', error);
                alert('Không thể cập nhật giảm giá. Vui lòng thử lại!');
            });
        });

        document.getElementById('addDiscountForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const newDiscount = {
                discount_name: document.getElementById('addDiscountName').value,
                discount_percent: document.getElementById('addDiscountValue').value,
                start_date: document.getElementById('startDate').value,
                end_date: document.getElementById('endDate').value,
            };
            fetch('http://127.0.0.1:8000/api/v1/discounts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(newDiscount),
            })
            .then(response => response.json())
            .then(discount => {
                fetchDiscounts();
                alert('Giảm giá mới đã được thêm!');
                const addDiscountModal = bootstrap.Modal.getInstance(document.getElementById('addDiscountModal'));
                addDiscountModal.hide();
            })
            .catch(error => {
                console.error('Lỗi khi thêm giảm giá mới:', error);
                alert('Không thể thêm giảm giá mới. Vui lòng thử lại!');
            });
        });

        document.getElementById('menuToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('open');
            content.classList.toggle('shift');
        });
    </script>
</body>

</html>