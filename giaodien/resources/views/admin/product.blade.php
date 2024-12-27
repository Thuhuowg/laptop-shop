

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
            <a class="nav-link" href="{{URL::to('/adusers')}}">Quản lý người dùng</a>
            <a class="nav-link" href="{{URL::to('/adproduct')}}">Quản lý sản phẩm</a>
            <a class="nav-link active" href="{{URL::to('/adcategory')}}">Quản lý danh mục</a>
            <a class="nav-link" href="{{URL::to('/addiscount')}}">Quản lý giảm giá</a>
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
                            <label for="addproductId" class="form-label">Danh mục</label>
                            <select class="form-select" id="addCategory" required>
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addDiscountId" class="form-label">Giảm giá</label>
                            <select class="form-select" id="addDiscount">
                                
                            </select>
                        </div>
                        <button class="btn btn-primary add-product">Thêm</button>
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
            url: "http://127.0.0.1:8000/api/v1/products",
            type: "GET",
            dataType: 'json',
            success: function (data) {
                const products = $('#productTable');
                products.empty();
                data.product.forEach(function(product) {
                    const row = `
                        <tr>
                            <td>${product.product_id}</td>
                            <td>${product.product_name}</td>
                            <td>${product.price}</td>
                            <td><img src="/fontend/images/product/${product.image_url}" alt="${product.product_name}" style="width: 50px; height: auto;"></td>
                            <td>${product.category.category_name}</td>
                            <td>${product.discount ? product.discount.discount_percent +"%" : 'Không có'}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-product" data-id="${product.product_id}">Sửa</button>
                                <button class="btn btn-danger btn-sm delete-product" data-id="${product.product_id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    products.append(row);
                    
                });

                //lấy ra dữ liệu danh mục và giảm giá để hiển thị ra form
                data.category.forEach(function(category){
                    const optionCate=$('<option></option>').attr('value', category.category_id).text(category.category_name);
                    $('#addCategory').append(optionCate);
                });

                data.discount.forEach(function(discount){
                    const optionDiscount=$('<option></option>').attr('value', discount.discount_id).text(discount.discount_name);
                    $('#addDiscount').append(optionDiscount);
                });
            },
            error: function (e) {
                console.log(xhr.responseText);
            }
        });

        //hàm thêm
        function addProduct(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            const data = {
                product_name: $('#addProductName').val(),
                price: $('#addProductPrice').val(),
                description: $('#addProductDescription').val(),
                image_url: $('#addProductImage').val(),
                category_id : $('#addCategory').val(),
                discount_id : $('#addDiscount').val(),
            };

            $.ajax({
                url: "http://127.0.0.1:8000/api/v1/products",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Sản phẩm mới đã được thêm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm xóa
        function deleteProduct(productId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/products/' + productId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    alert('Xóa sản phẩm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm hiển thị form chỉnh sửa thông tin
        function editProduct(productId) {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/products/' + productId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // Hiện modal chỉnh sửa
                    const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                    editProductModal.show();
                    const products = $('#editProductForm');
                    let option = '';
                    let optionDiscount = ``;
                    console.log(data.category);
                    data.category.forEach(function(item) {
                        if (item.category_id == data.product.category_id) {
                            option += `<option value="${item.category_id}" selected>${item.category_name}</option>`;
                        } else {
                            option += `<option value="${item.category_id}">${item.category_name}</option>`;
                        }
                    });

                    data.discount.forEach(function(item) {
                        if (item.discount_id == data.discount.discount_id) {
                            optionDiscount += `<option value="${item.discount_id}" selected>${item.discount_name}</option>`;
                        } else {
                            optionDiscount += `<option value="${item.discount_id}">${item.discount_name}</option>`;
                        }
                    });
                    const row = `
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="editProductName" required value="${data.product.product_name}">
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="editProductPrice" required value="${data.product.price}">
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="editProductDescription" rows="3" required> ${data.product.description}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Ảnh sản phẩm</label>
                            <input type="text" class="form-control" id="editProductImage" value="${data.product.image_url}"required>
                        </div>
                        <div class="mb-3">
                            <label for="editproductId" class="form-label">Danh mục</label>
                            <select class="form-select" id="editCategory" required>
                                `+option+`
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDiscountId" class="form-label">Giảm giá</label>
                            <select class="form-select" id="editDiscount">
                                `+optionDiscount+`                            
                            </select>
                        </div>
                        <button class="btn btn-primary update-product" data-id="${data.product.product_id}">Lưu</button>
                    `;
                    products.empty().append(row);
                    

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm cập nhật
        function updateProduct(productId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            const data = {
                product_name: $('#editProductName').val(),
                price: $('#editProductPrice').val(),
                description: $('#editProductDescription').val(),
                image_url: $('#editProductImage').val(),
                category_id : $('#editCategory').val(),
                discount_id : $('#editDiscount').val(),
            };
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/products/'+ productId,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Thông tin sản phẩm được lưu thành công!");
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            //gọi hàm thêm danh mục
            $(document).on('click', '.add-product', function(event) {
                event.preventDefault();
                addProduct();
            });
    
            //gọi hàm xóa danh mục
            $(document).on('click', '.delete-product', function(event) {
                event.preventDefault();
                
                var productId = $(this).data('id');
                
                // Xác nhận trước khi xóa
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
                    deleteProduct(productId);
                }
            });

            //gọi hàm hiển thị form chỉnh sửa
            $(document).on('click', '.edit-product', function(event) {
                event.preventDefault();
                
                var productId = $(this).data('id');
                editProduct(productId);
            });

            //gọi hàm cập nhật danh mục
            $(document).on('click', '.update-product', function(event) {
                event.preventDefault();
                
                var productId = $(this).data('id');
                updateProduct(productId);
            });
            
        });
    </script>
    
</body>

</html>