<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
        }

        .footer {
            background-color: #00264d;
            position: relative;
            bottom: 0;
            width: 100%;
            padding: 20px;
            text-align: center;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider::before {
            margin-right: 0.25em;
        }

        .divider::after {
            margin-left: 0.25em;
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="img-fluid rounded shadow-lg" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
                    <form id="login-form" class="form-container">
                        <div class="d-flex flex-row align-items-center justify-content-center mb-4">
                            <p class="lead fw-normal mb-0 me-3">Đăng nhập với</p>
                            <button type="button" class="btn btn-outline-primary btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="btn btn-outline-info btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-floating mx-1">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>

                        <div class="divider my-4">
                            <p class="text-center fw-bold mb-0">Hoặc</p>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                placeholder="Nhập địa chỉ email hợp lệ" required>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input me-2" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                            </div>
                            <a href="#" class="text-body small">Quên mật khẩu?</a>
                        </div>

                        <div class="text-center text-lg-start">
                            <button type="button" id="login-button" class="btn btn-primary btn-lg px-5 py-2">Đăng
                                nhập</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Chưa có tài khoản? <a href="{{ route('register') }}"
                                    class="link-danger">Đăng ký</a></p>
                        </div>

                        <!-- Phần tử hiển thị lỗi -->
                        <div id="errorMessage" style="color: red;"></div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer py-4 text-white text-center">
            <div>Bản quyền &copy; 2024. Mọi quyền được bảo lưu.</div>
            <div class="social-links mt-3">
                <a href="#" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </footer>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('login-button').addEventListener('click', async function (event) {
            event.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorMessage = document.getElementById('errorMessage');

            errorMessage.textContent = '';

            if (!email || !password) {
                errorMessage.textContent = 'Vui lòng nhập đầy đủ email và mật khẩu.';
                return;
            }

            const payload = {
                email,
                password,
            };

            try {
                const response = await fetch('http://127.0.0.1:8001/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    errorMessage.textContent = errorData.message || 'Đã xảy ra lỗi khi đăng nhập.';
                    return;
                }

                const data = await response.json();

                if (data.token) {
                    // Lưu token vào cookie
                    document.cookie = `token=${data.token}; path=/; SameSite=Lax; Secure; max-age=86400`;
                    const userResponse = await fetch('http://127.0.0.1:8001/api/users/{id}', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${data.token}`
                        }
                    });

                    const userData = await userResponse.json();
                    // Lưu thông tin người dùng vào localStorage
                    localStorage.setItem('user_id', data.user.user_id); // Sửa thành user_id
                    localStorage.setItem('role_id', data.user.role_id); // Sửa thành role_id
                    localStorage.setItem('username', userData.username);

                    // Chuyển hướng dựa trên vai trò
                    const redirectUrl = data.user.role_id === 1 ? '/home' : '/users';
                    window.location.href = redirectUrl;
                } else {
                    errorMessage.textContent = 'Phản hồi từ server không hợp lệ!';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Đã xảy ra lỗi khi đăng nhập. Vui lòng kiểm tra kết nối và thử lại.';
            }
        });
    </script>
</body>

</html>