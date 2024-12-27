<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Home | Laptop-Shoppe')</title>
    <link href="/fontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="/fontend/css/font-awesome.min.css" rel="stylesheet">
    <link href="/fontend/css/prettyPhoto.css" rel="stylesheet">
    <link href="/fontend/css/price-range.css" rel="stylesheet">
    <link href="/fontend/css/animate.css" rel="stylesheet">
    <link href="/fontend/css/sweetalert.css" rel="stylesheet">
    <link href="/fontend/css/main.css" rel="stylesheet">
    <link href="/fontend/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/fontend/js/html5shiv.js"></script>
    <script src="/fontend/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/fontend/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="/fontend/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="/fontend/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="/fontend/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/fontend/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
    <header id="header">
        <div class="header-middle">

            <div class="container">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="/home"><img src="/fontend/images/logolaptop.png" alt="" /></a>
                        </div>
                        
                    </div>
                    <li>
                        <a href="/transaction_history" id="order-history-link">
                            <i class="fa fa-history"></i> Lịch sử đơn hàng
                        </a>
                    </li>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav" id="auth-menu">
                               
                                <li>
                                    <form id="search-form" class="search-bar">
                                        <input type="text" class="search-input" placeholder="Tìm kiếm...">
                                    </form>
                                </li>
                                <li>
                                    <a href="tel:+84123456789" id="phone-icon">
                                        <i class="fa fa-phone"></i> +84 123 456 789
                                    </a>
                                </li>
                                <li>
                                <a href="/cart" id="cart-icon">
                                <i class="fa fa-shopping-cart"></i> Giỏ hàng
                                <span class="cart-count badge">0</span>
                            </a>
                                </li>
                                <!-- Icon Người dùng -->
                                <li>
                                    <a href="/login" id="auth-link">
                                        <i class="fa fa-user"></i> Đăng Nhập
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div id="main-content">
        @yield('content')
    </div>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>Laptop</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="/san-pham">
                                    <div class="iframe-img">
                                        <img src="/fontend/images/footer1.webp" alt="" />
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="/fontend/images/map.png" alt="" />
                            <p>Km 10, đường Nguyễn Trãi, quận Thanh Xuân, thành phố Hà Nội</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2024 website đồ án phát triển phần mềm hướng dịch vụ</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="/fontend/js/jquery.js"></script>
    <script src="/fontend/js/bootstrap.min.js"></script>
    <script src="/fontend/js/jquery.scrollUp.min.js"></script>
    <script src="/fontend/js/price-range.js"></script>
    <script src="/fontend/js/jquery.prettyPhoto.js"></script>
    <script src="/fontend/js/main.js"></script>
    <script src="/fontend/js/sweetalert.min.js"></script>
    <script src="/fontend/js/home.js"></script>
    <script src="/fontend/js/cart.js"></script>
    <script src="/fontend/js/checkout.js"></script>
    <script>
    function initializeHeader() {
        updateAuthLink();
        // Function to delete a cookie by name
        function deleteCookie(name) {
            document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
        }

        // Function to get the token from cookies
        function getToken() {
            const cookieString = document.cookie.split('; ').find(row => row.startsWith('token='));
            console.log("Token from cookie:", cookieString);
            return cookieString ? cookieString.split('=')[1] : null;
        }
        // Function to handle logout
        function handleLogout() {
            deleteCookie('token');
            localStorage.removeItem('user_id');
            localStorage.removeItem('username'); // Xóa tên người dùng
            updateAuthLink(); // Cập nhật lại liên kết đăng nhập/đăng xuất
            window.location.href = '/'; // Chuyển hướng về trang chủ sau khi đăng xuất
        }

        // Function to update the auth link based on token presence
        function updateAuthLink() {
            const authLink = document.getElementById('auth-link');
            if (!authLink) {
                console.error("Element with ID 'auth-link' not found in DOM.");
                return;
            }

            const token = getToken();
            if (token) {
                authLink.textContent = 'Đăng xuất';
                authLink.href = '#'; // Không dẫn đến trang mới
                authLink.onclick = handleLogout; // Gọi hàm logout khi nhấn
            } else {
                authLink.textContent = 'Đăng nhập';
                authLink.href = '/login'; // Đường dẫn đến trang đăng nhập
                authLink.onclick = null; // Không có sự kiện click
            }
        }

        // Call the function to update the link
        
    }

    // Ensure the function runs after header.html is loaded into the DOM
    document.addEventListener('DOMContentLoaded', initializeHeader);
    
    const updateCartCount = () => {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        document.querySelector(".cart-count").innerText = totalItems;
    };

    // Cập nhật ngay khi tải trang
    updateCartCount();
    
</script>
    
</body>

</html>