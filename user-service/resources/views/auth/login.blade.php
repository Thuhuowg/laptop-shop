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
            background-color: #FE980F;
            position: relative; /* Thay đổi vị trí từ fixed sang relative */
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
        .divider::before, .divider::after {
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
                <form action="{{ route('login') }}" method="POST" class="form-container">
                    @csrf

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
                        <p class="text-center fw-bold mb-0">Or</p>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" required />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input me-2" type="checkbox" id="remember_me" name="remember" />
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                        <a href="#" class="text-body small">Forgot password?</a>
                    </div>

                    <div class="text-center text-lg-start">
                        <button type="submit" class="btn btn-warning btn-lg px-5 py-2">Login</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}" class="link-danger">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer mb-5 py-4 text-white text-center fixed-bottom">
        <div>Copyright &copy; 2024. All rights reserved.</div>
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
</body>
</html>
