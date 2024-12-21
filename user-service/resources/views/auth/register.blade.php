<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <!-- Hình ảnh -->
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid rounded shadow-lg" alt="Registration Image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h1 class="mb-4">Đăng ký tài khoản</h1>

                    <!-- Thông báo thành công -->
                    @if(session('success'))
                        <p class="text-success">{{ session('success') }}</p>
                    @endif

                    <!-- Hiển thị lỗi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form đăng ký -->
                    <form action="/register" method="POST">
                        @csrf <!-- Token CSRF -->

                        <!-- Tên người dùng -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="username">Tên người dùng</label>
                            <input type="text" id="username" name="username" class="form-control form-control-lg"
                                required>
                            
                        </div>

                        <!-- Email -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                            
                        </div>

                        <!-- Mật khẩu -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg"
                                required>
                            
                        </div>

                        <!-- Nhập lại mật khẩu -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="password_confirmation">Nhập lại mật khẩu</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control form-control-lg" required>

                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="phone_number">Số điện thoại</label>
                            <input type="phone_number" id="phone_number" name="phone_number"
                                class="form-control form-control-lg" required>
                            
                        </div>

                        <!-- Địa chỉ -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="address">Địa chỉ</label>
                            <input type="address" id="address" name="address" class="form-control form-control-lg"
                                required>
                            
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-warning btn-lg btn-block w-100" style="display: block; margin: 0 auto;">Đăng ký</button>


                        <!-- Link đến form đăng nhập -->
                        <div class="text-center mt-3">
                            <p>Đã có tài khoản? <a href="/login" class="text-warning">Đăng nhập ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>