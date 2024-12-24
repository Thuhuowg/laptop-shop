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
            <a class="nav-link" href="/users">Quản lý người dùng</a>
            <a class="nav-link" href="/product">Quản lý sản phẩm</a>
            <a class="nav-link active" href="/category">Quản lý danh mục</a>
            <a class="nav-link" href="/discount">Quản lý giảm giá</a>
        </nav>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="menu-btn" id="menuToggle">☰</button>
            <a class="navbar-brand" href="/category">Quản lý danh mục</a>
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
                            <input type="text" class="form-control" id="addCategoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addCategoryDescription" class="form-label">Miêu tả</label>
                            <textarea class="form-control" id="addCategoryDescription" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
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
                        <input type="hidden" id="editCategoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="editCategoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Miêu tả</label>
                            <textarea class="form-control" id="editCategoryDescription" required></textarea>
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
        function fetchCategories() {
            fetch('http://127.0.0.1:8000/api/v1/categories')
                .then(response => response.json())
                .then(data => {
                    const categoryTable = document.getElementById('categoryTable');
                    let rows = '';
                    data.forEach(category => {
                        rows += `
                            <tr id="category-${category.category_id}">
                                <td>${category.category_id}</td>
                                <td>${category.category_name}</td>
                                <td>${category.description}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editCategory(${category.category_id})">Sửa</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteCategory(${category.category_id})">Xóa</button>
                                </td>
                            </tr>
                        `;
                    });
                    categoryTable.innerHTML = rows;
                })
                .catch(error => {
                    console.error('Error fetching category data:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', fetchCategories);

        // Hàm để xóa danh mục
        function deleteCategory(id) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                fetch(`http://127.0.0.1:8000/api/v1/categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error('Xóa không thành công');
                    const categoryRow = document.getElementById(`category-${id}`);
                    if (categoryRow) categoryRow.remove();
                    alert('Danh mục đã được xóa thành công!');
                    fetchCategories(); // Gọi lại hàm để làm mới danh sách
                })
                .catch(error => {
                    console.error('Lỗi khi xóa danh mục:', error);
                    alert('Không thể xóa danh mục. Vui lòng thử lại!');
                });
            }
        }

        // Hàm hiển thị modal và điền thông tin danh mục cần sửa
        function editCategory(id) {
            fetch(`http://127.0.0.1:8000/api/v1/categories/${id}`)
                .then(response => response.json())
                .then(category => {
                    if (category.message) {
                        alert(category.message); // Nếu có thông báo lỗi từ API
                        return;
                    }
                    document.getElementById('editCategoryId').value = category.category_id;
                    document.getElementById('editCategoryName').value = category.category_name;
                    document.getElementById('editCategoryDescription').value = category.description;

                    const editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                    editCategoryModal.show();
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thông tin danh mục:', error);
                    alert('Không thể lấy thông tin danh mục!');
                });
        }

        // Hàm để cập nhật thông tin danh mục
        document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('editCategoryId').value;
            const updatedCategory = {
                category_name: document.getElementById('editCategoryName').value,
                description: document.getElementById('editCategoryDescription').value,
            };
            fetch(`http://127.0.0.1:8000/api/v1/categories/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(updatedCategory),
            })
            .then(response => response.json())
            .then(updatedCategory => {
                fetchCategories(); // Gọi lại hàm để làm mới danh sách
                alert('Danh mục đã được cập nhật thành công!');
                const editCategoryModal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
                editCategoryModal.hide();
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật danh mục:', error);
                alert('Không thể cập nhật danh mục. Vui lòng thử lại!');
            });
        });

        // Thêm danh mục mới
        document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const newCategory = {
                category_name: document.getElementById('addCategoryName').value,
                description: document.getElementById('addCategoryDescription').value,
            };
            fetch('http://127.0.0.1:8000/api/v1/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(newCategory),
            })
            .then(response => response.json())
            .then(category => {
                fetchCategories(); // Gọi lại hàm để làm mới danh sách
                alert('Danh mục mới đã được thêm!');
                const addCategoryModal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                addCategoryModal.hide();
            })
            .catch(error => {
                console.error('Lỗi khi thêm danh mục mới:', error);
                alert('Không thể thêm danh mục mới. Vui lòng thử lại!');
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