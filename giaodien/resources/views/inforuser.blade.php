@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Thông Tin Cá Nhân | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow" style="margin-left: 350px;">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Thông Tin Cá Nhân</h3>
                </div>
                <div class="card-body">
                    <form id="profile-form">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Tên Người Dùng:</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number" class="form-label">Số Điện Thoại:</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Địa Chỉ:</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Mật Khẩu (Để trống nếu không đổi):</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="margin-left: 121px;">Cập Nhật Thông Tin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userId = localStorage.getItem('user_id'); // Lấy ID từ localStorage
        const apiUrl = 'http://127.0.0.1:8001/api/users'; // Thay bằng URL API của bạn

        // Lấy thông tin người dùng
        fetch(`${apiUrl}/${userId}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Không thể tải thông tin người dùng.');
                }
                return response.json();
            })
            .then((data) => {
                // Điền thông tin vào form
                document.getElementById('username').value = data.username;
                document.getElementById('email').value = data.email;
                document.getElementById('phone_number').value = data.phone_number || '';
                document.getElementById('address').value = data.address || '';
            })
            .catch((error) => {
                console.error(error);
            });

        // Xử lý cập nhật thông tin
        const form = document.getElementById('profile-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const updatedData = {
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                phone_number: document.getElementById('phone_number').value,
                address: document.getElementById('address').value,
                password: document.getElementById('password').value,
            };

            // Gửi yêu cầu cập nhật
            fetch(`${apiUrl}/${userId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(updatedData),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Cập nhật thông tin không thành công.');
                    }
                    return response.json();
                })
                .then((data) => {
                    alert('Cập nhật thông tin thành công!');
                })
                .catch((error) => {
                    console.error(error);
                });
        });
    });
</script>
@endsection
