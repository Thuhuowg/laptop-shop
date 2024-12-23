<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
            overflow-x: hidden;
            /* Prevent horizontal scroll */
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
            /* Smooth slide effect */
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
            <a class="nav-link" href="#userList">User Management</a>
        </nav>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="menu-btn" id="menuToggle">☰</button>
            <a class="navbar-brand" href="#userList">User Management</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4 content" id="content">

        <!-- User List Section -->
        <section id="userList">
            <h1>Danh sách người dùng</h1>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <!-- Dữ liệu sẽ được thêm vào đây -->
                </tbody>
            </table>
        </section>
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Sửa Thông Tin Người Dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editPhone">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress">
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
            fetch('http://127.0.0.1:8001/api/users', {
                method: 'GET',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const userTable = document.getElementById('userTable');
                    let rows = '';
                    data.forEach(user => {
                        rows += `
            <tr id="user-${user.user_id}">
                <td>${user.user_id}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${user.phone_number || 'N/A'}</td>
                <td>${user.address || 'N/A'}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editUser(${user.user_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.user_id})">Delete</button>
                </td>
            </tr>
        `;
                    });
                    console.log(rows);
                    userTable.innerHTML = rows;
                })
                .catch(error => {
                    console.error('Error fetching user data from API:', error);
                });
        }
        document.addEventListener('DOMContentLoaded', fetchFromAPI);

        // Hàm để xóa người dùng
        function deleteUser(id) {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                // Gửi yêu cầu DELETE đến API
                fetch(`http://127.0.0.1:8001/api/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Xóa người dùng không thành công!');
                        }
                        return response.json();
                    })
                    .then(() => {
                        // Xóa dòng người dùng khỏi bảng sau khi API xóa thành công
                        const userRow = document.getElementById(`user-${id}`);
                        if (userRow) {
                            userRow.remove();
                        }
                        alert('Người dùng đã được xóa thành công!');
                    })
                    .catch(error => {
                        console.error('Lỗi khi xóa người dùng:', error);
                        alert('Không thể xóa người dùng. Vui lòng thử lại!');
                    });
            }
        }

        // Sidebar Toggle
        document.getElementById('menuToggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
            const content = document.getElementById('content');
            content.classList.toggle('shift');
        });

         // Hàm hiển thị modal và điền thông tin người dùng cần sửa
    function editUser(id) {
        // Gửi yêu cầu GET để lấy thông tin chi tiết người dùng từ API
        fetch(`http://127.0.0.1:8001/api/users/${id}`, {
            method: 'GET',
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể lấy thông tin người dùng!');
                }
                return response.json();
            })
            .then(user => {
                // Điền thông tin người dùng vào form
                document.getElementById('editUserId').value = user.user_id;
                document.getElementById('editUsername').value = user.username;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editPhone').value = user.phone_number || '';
                document.getElementById('editAddress').value = user.address || '';

                // Hiển thị modal
                const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editUserModal.show();
            })
            .catch(error => {
                console.error('Lỗi khi lấy thông tin người dùng:', error);
                alert('Không thể tải thông tin người dùng. Vui lòng thử lại!');
            });
    }

    // Xử lý khi form sửa được submit
    document.getElementById('editUserForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Ngăn chặn reload trang

        const userId = document.getElementById('editUserId').value;
        const updatedData = {
            username: document.getElementById('editUsername').value,
            email: document.getElementById('editEmail').value,
            phone_number: document.getElementById('editPhone').value,
            address: document.getElementById('editAddress').value,
        };

        // Gửi yêu cầu PUT để cập nhật thông tin người dùng
        fetch(`http://127.0.0.1:8001/api/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedData),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Cập nhật người dùng không thành công!');
                }
                return response.json();
            })
            .then(() => {
                // Cập nhật dữ liệu trên bảng mà không cần tải lại trang
                const userRow = document.getElementById(`user-${userId}`);
                userRow.innerHTML = `
                    <td>${userId}</td>
                    <td>${updatedData.username}</td>
                    <td>${updatedData.email}</td>
                    <td>${updatedData.phone_number || 'N/A'}</td>
                    <td>${updatedData.address || 'N/A'}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editUser(${userId})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${userId})">Delete</button>
                    </td>
                `;

                // Đóng modal và hiển thị thông báo
                const editUserModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                editUserModal.hide();
                alert('Cập nhật người dùng thành công!');
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật người dùng:', error);
                alert('Không thể cập nhật người dùng. Vui lòng thử lại!');
            });
    });
    </script>
</body>

</html>