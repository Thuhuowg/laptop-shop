<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .navbar {
            background-color: rgb(229, 149, 2);
        }

        /* Sidebar Styles */
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

        /* Content Styles */
        .content {
            transition: margin-left 0.3s ease;
        }

        .content.shift {
            margin-left: 250px;
        }

        /* Menu Button Style */
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
        <a class="nav-link" href="/users">Quản lý người dùng</a>
            <a class="nav-link" href="/product">Quản lý sản phẩm</a>
            <a class="nav-link" href="/category">Quản lý danh mục</a>
            <a class="nav-link" href="/discount">Quản lý giảm giá</a>
        </nav>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="menu-btn" id="menuToggle">☰</button>
            <a class="navbar-brand" href="/product">Quản lý Sản Phẩm</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4 content" id="content">
        <section id="productList">
            <h1>Danh sách sản phẩm</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Thêm Sản Phẩm</button>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Ảnh</th>
                        <th>Danh mục</th>
                        <th>Giảm giá</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <!-- Dữ liệu sẽ được thêm vào đây -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Thêm Sản Phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label for="addProductId" class="form-label">ID sản phẩm</label>
                            <input type="text" class="form-control" id="addProductId" required>
                        </div>
                        <div class="mb-3">
                            <label for="addProductName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="addProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addProductPrice" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="addProductPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="addProductDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="addProductDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addProductImage" class="form-label">Ảnh sản phẩm</label>
                            <input type="text" class="form-control" id="addProductImage" required>
                        </div>
                        <div class="mb-3">
                            <label for="addCategoryId" class="form-label">Danh mục</label>
                            <select class="form-select" id="addCategoryId" required>
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addDiscountId" class="form-label">Giảm giá</label>
                            <select class="form-select" id="addDiscountId">
                                <!-- Tùy chỉnh danh sách giảm giá ở đây -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Sửa Thông Tin Sản Phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="editProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="editProductPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="editProductDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Ảnh sản phẩm</label>
                            <input type="text" class="form-control" id="editProductImage">
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryId" class="form-label">Danh mục</label>
                            <select class="form-select" id="editCategoryId" required>
                                <!-- Tùy chỉnh danh sách danh mục ở đây -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDiscountId" class="form-label">Giảm giá</label>
                            <select class="form-select" id="editDiscountId">
                                <!-- Tùy chỉnh danh sách giảm giá ở đây -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fetch API -->
    <script>
        function fetchFromAPI() {
            fetch('http://127.0.0.1:8000/api/v1/products', {
                method: 'GET',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const productTable = document.getElementById('productTable');
                    let rows = '';
                    data.forEach(product => {
                        rows += `
            <tr id="product-${product.product_id}">
                <td>${product.product_id}</td>
                <td>${product.product_name}</td>
                <td>${product.price}</td>
                <td><img src="/fontend/images/product/${product.image_url}" alt="${product.product_name}" style="width: 50px; height: auto;"></td>
                <td>${product.category.category_name}</td>
                <td>${product.discount ? product.discount.discount_percent +"%" : 'Không có'}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editProduct('${product.product_id}')">Sửa</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct('${product.product_id}')">Xóa</button>
                </td>
            </tr>
        `;
                    });
                    productTable.innerHTML = rows;
                })
                .catch(error => {
                    console.error('Error fetching product data from API:', error);
                });
        }
        document.addEventListener('DOMContentLoaded', fetchFromAPI);

        // Hàm để xóa sản phẩm
        function deleteProduct(id) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                fetch(`http://127.0.0.1:8000/api/v1/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Xóa sản phẩm không thành công!');
                        }
                        return response.json();
                    })
                    .then(() => {
                        const productRow = document.getElementById(`product-${id}`);
                        if (productRow) {
                            productRow.remove();
                        }
                        alert('Sản phẩm đã được xóa thành công!');
                    })
                    .catch(error => {
                        console.error('Lỗi xóa sản phẩm:', error);
                    });
            }
        }

        // Hàm để sửa thông tin sản phẩm
        function editProduct(id) {
            fetch(`http://127.0.0.1:8000/api/v1/products/${id}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('editProductId').value = product.product_id;
                    document.getElementById('editProductName').value = product.product_name;
                    document.getElementById('editProductPrice').value = product.price;
                    document.getElementById('editProductDescription').value = product.description;
                    document.getElementById('editProductImage').value = product.image_url;
                    document.getElementById('editCategoryId').value = product.category_id;
                    document.getElementById('editDiscountId').value = product.discount_id || '';

                    const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                    editProductModal.show();
                })
                .catch(error => console.error('Error fetching product data for edit:', error));
        }

        // Xử lý form thêm sản phẩm
        const addProductForm = document.getElementById('addProductForm');
        addProductForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(addProductForm);

            fetch('http://127.0.0.1:8000/api/v1/products', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert('Sản phẩm đã được thêm!');
                    addProductForm.reset();
                    $('#addProductModal').modal('hide');
                    fetchFromAPI();
                })
                .catch(error => {
                    console.error('Error adding product:', error);
                });
        });

        // Xử lý form sửa sản phẩm
        const editProductForm = document.getElementById('editProductForm');
        editProductForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const productId = document.getElementById('editProductId').value;
            const formData = new FormData(editProductForm);

            fetch(`http://127.0.0.1:8000/api/v1/products/${productId}`, {
                method: 'PUT',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert('Sản phẩm đã được sửa!');
                    $('#editProductModal').modal('hide');
                    fetchFromAPI();
                })
                .catch(error => {
                    console.error('Error updating product:', error);
                });
        });
    </script>
    <script>
    document.getElementById('menuToggle').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        // Toggle class 'open' cho sidebar
        sidebar.classList.toggle('open');
        // Toggle class 'shift' cho content
        content.classList.toggle('shift');
    });
</script>
</body>

</html>