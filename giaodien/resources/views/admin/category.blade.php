<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
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
            <a class="navbar-brand" href="/category_management.html">Quản lý danh mục</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4 content" id="content">
        <section id="categoryList">
            <h1>Danh sách danh mục</h1>

            <!-- Add Category Button -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Thêm Danh Mục</button>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Miêu tả</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTable">
                    <!-- Dữ liệu sẽ được thêm vào đây -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Thêm Danh Mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="addCategoryName" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="addCategoryDescription" class="form-label">Miêu tả</label>
                            <textarea class="form-control" id="description" required></textarea>
                        </div>
                        <button class="btn btn-primary add-category">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Sửa Danh Mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        
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
            url: "http://127.0.0.1:8000/api/v1/categories",
            type: "GET",
            dataType: 'json',
            success: function (data) {
                const categories = $('#categoryTable');
                categories.empty(); 
                data.forEach(function(category) {
                    const row = `
                        <tr id="category-${category.category_id}">
                            <td>${category.category_id}</td>
                            <td>${category.category_name}</td>
                            <td>${category.description}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-category" data-id="${category.category_id}">Sửa</button>
                                <button class="btn btn-danger btn-sm delete-category" data-id="${category.category_id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    categories.append(row);
                    
                });
            },
            error: function (e) {
                console.log(xhr.responseText);
            }
        });

        //hàm thêm
        function addCategory(){
            const data = {
                category_name: $('#category_name').val(),
                description: $('#description').val(),
            };

            $.ajax({
                url: "http://127.0.0.1:8000/api/v1/categories",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Danh mục mới đã được thêm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm xóa danh mục
        function deleteCategory(categoryId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/categories/' + categoryId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    alert('Xóa danh mục sản phẩm thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm hiển thị form chỉnh sửa thông tin
        function editCategory(categoryId) {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/categories/' + categoryId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Hiện modal chỉnh sửa
                    const editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                    editCategoryModal.show();
                    const categories = $('#editCategoryForm');
                    const row = `
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="editCategoryName" value="${data.category_name}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Miêu tả</label>
                            <textarea class="form-control" id="editCategoryDescription" required>${data.description}</textarea>
                        </div>
                        <button class="btn btn-primary update-category" data-id="${data.category_id}">Lưu</button>
                    `;
                    categories.empty().append(row);
                        

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        //hàm cập nhật danh mục
        function updateCategory(categoryId) {
            const data = {
                category_name: $('#editCategoryName').val(),
                description: $('#editCategoryDescription').val(),
            };
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/categories/'+ categoryId,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Thông tin danh mục sản phẩm được lưu thành công!");
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            //gọi hàm thêm danh mục
            $(document).on('click', '.add-category', function(event) {
                event.preventDefault();
                addCategory();
            });
    
            //gọi hàm xóa danh mục
            $(document).on('click', '.delete-category', function(event) {
                event.preventDefault();
                
                var categoryId = $(this).data('id');
                
                // Xác nhận trước khi xóa
                if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
                    deleteCategory(categoryId);
                }
            });

            //gọi hàm hiển thị form chỉnh sửa
            $(document).on('click', '.edit-category', function(event) {
                event.preventDefault();
                
                var categoryId = $(this).data('id');
                editCategory(categoryId);
            });

            //gọi hàm cập nhật danh mục
            $(document).on('click', '.update-category', function(event) {
                event.preventDefault();
                
                var categoryId = $(this).data('id');
                updateCategory(categoryId);
            });
            
        });
    </script>
    
</body>

</html>