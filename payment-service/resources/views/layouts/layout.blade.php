<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | Laptop-Shoppe</title>
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/fontend/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/fontend/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/fontend/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/fontend/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
<header id="header">
    <div class="header-middle">
        
        <div class="container">
            
            <div class="row">
            <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="/trang-chu"><img src="/fontend/images/logolaptop.png" alt="" /></a>
                    </div>
                </div>
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
                                    <span id="cart-count" class="badge">0</span>
                                </a>
                            </li>
                            <!-- Icon Người dùng -->
                            <li>
                                <a href="javascript:void(0);" id="user-icon">
                                    <i class="fa fa-user"></i> Tài khoản
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

    <script>
        $(document).ready(function() {
            // Load user status (Login/Logout)
            loadUserStatus();

            // Handle Add to Cart
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '/api/add-to-cart',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(response) {
                        swal("Đã thêm sản phẩm vào giỏ hàng");
                    }
                });
            });

            // Handle Checkout
            $('#checkout-link').click(function() {
                $.ajax({
                    url: '/api/checkout',
                    method: 'POST',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "/checkout";
                        } else {
                            alert("Bạn cần đăng nhập trước.");
                        }
                    }
                });
            });
        });

        // Function to load user authentication status
        $(document).ready(function () {
        $('#user-icon').click(function () {
            // Kiểm tra trạng thái đăng nhập
            $.ajax({
                url: '/api/user-status', // API kiểm tra trạng thái đăng nhập
                method: 'GET',
                success: function (response) {
                    if (response.logged_in) {
                        // Nếu đã đăng nhập, chuyển hướng tới trang tài khoản
                        window.location.href = '/account';
                    } else {
                        // Nếu chưa đăng nhập, hiển thị tùy chọn
                        Swal.fire({
                            title: 'Bạn chưa đăng nhập!',
                            text: "Vui lòng chọn một trong hai hành động dưới đây:",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Đăng nhập',
                            cancelButtonText: 'Đăng ký',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Người dùng chọn Đăng nhập
                                window.location.href = '/login';
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                // Người dùng chọn Đăng ký
                                window.location.href = '/register';
                            }
                        });
                    }
                },
                error: function () {
                    alert('Không thể kiểm tra trạng thái đăng nhập. Vui lòng thử lại sau.');
                }
            });
        });
    });
    </script>
</body>
</html>
