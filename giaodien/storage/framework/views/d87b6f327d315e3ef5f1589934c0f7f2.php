<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $__env->yieldContent('title', 'Home | Laptop-Shoppe'); ?></title>
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
        <?php echo $__env->yieldContent('content'); ?>
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
            // Function to delete a cookie by name
            function deleteCookie(name) {
                document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
            }

            // Function to get the token from cookies
            function getToken() {
                const cookieString = document.cookie.split('; ').find(row => row.startsWith('token='));
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
            updateAuthLink();
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
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryLinks = document.querySelectorAll('.filter-category');
            const productsList = document.getElementById('products-list');

            categoryLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    // Lấy category_id từ thuộc tính data-id
                    const categoryId = this.getAttribute('data-id');

                    // Gọi API lọc sản phẩm theo category_id
                    fetch(`http://127.0.0.1:8000/api/products?category_id=${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Xóa danh sách sản phẩm cũ
                                productsList.innerHTML = '';

                                // Hiển thị danh sách sản phẩm mới
                                if (data.data.length > 0) {
                                    data.data.forEach(product => {
                                        const productHTML = `
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <a href="/product-detail?id=${product.product_id}">
                                                        <img src="${product.image_url ? '/fontend/images/product/' + product.image_url : '/fontend/images/no-image.png'}" alt="${product.product_name}" />
                                                        <h2>${new Intl.NumberFormat('vi-VN').format(product.price)} VNĐ</h2>
                                                        <p>${product.product_name}</p>
                                                    </a>
                                                    <button type="button" class="btn btn-default add-to-cart" data-id_product="${product.product_id}" name="add-to-cart">
                                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                        productsList.innerHTML += productHTML;
                                    });
                                } else {
                                    productsList.innerHTML = '<p>Không có sản phẩm nào thuộc danh mục này.</p>';
                                }
                            } else {
                                alert(data.message || 'Có lỗi xảy ra khi tải sản phẩm.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Không thể tải sản phẩm.');
                        });
                });
            });
        });
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productsList = document.getElementById('products-list');
            const applyFiltersButton = document.getElementById('apply-filters');

            // Hàm gọi API lọc sản phẩm
            function filterProducts() {
                // Lấy danh sách category_id đã chọn
                const selectedCategories = Array.from(document.querySelectorAll('.filter-category-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                // Lấy danh sách price_range đã chọn
                const selectedPriceRanges = Array.from(document.querySelectorAll('.filter-price-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                // Tạo URL với query string từ các bộ lọc
                const url = new URL('http://127.0.0.1:8000/api/products/filter');
                if (selectedCategories.length > 0) url.searchParams.append('category_id', selectedCategories.join(','));
                if (selectedPriceRanges.length > 0) url.searchParams.append('price_range', selectedPriceRanges.join(','));

                // Gọi API
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Xóa danh sách sản phẩm cũ
                            productsList.innerHTML = '';

                            // Hiển thị danh sách sản phẩm mới
                            if (data.data.length > 0) {
                                data.data.forEach(product => {
                                    const productHTML = `
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <a href="/product-detail?id=${product.product_id}">
                                                    <img src="${product.image_url ? '/fontend/images/product/' + product.image_url : '/fontend/images/no-image.png'}" alt="${product.product_name}" />
                                                    <h2>${new Intl.NumberFormat('vi-VN').format(product.price)} VNĐ</h2>
                                                    <p>${product.product_name}</p>
                                                </a>
                                                <button type="button" class="btn btn-default add-to-cart" data-id_product="${product.product_id}" name="add-to-cart">
                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                                    productsList.innerHTML += productHTML;
                                });
                            } else {
                                productsList.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
                            }
                        } else {
                            alert(data.message || 'Có lỗi xảy ra khi tải sản phẩm.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Không thể tải sản phẩm.');
                    });
            }

            // Gắn sự kiện click vào nút "Áp dụng bộ lọc"
            applyFiltersButton.addEventListener('click', function () {
                filterProducts();
            });
        });
    </script>

</body>

</html><?php /**PATH C:\xampp\htdocs\laptop-shop\giaodien\resources\views/layout/layout.blade.php ENDPATH**/ ?>