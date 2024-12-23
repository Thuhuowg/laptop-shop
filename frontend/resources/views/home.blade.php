@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('title', 'Home | Laptop-Shoppe')  <!-- Tiêu đề trang -->

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" id="slider-content">
                    <!-- Slide images -->
                    <div class="item active">
                        <div class="col-sm-12">
                            <img style="width: 100%;" src="/fontend/images/slider1.webp" class="girl img-responsive" alt="Slide 1" />
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-sm-12">
                            <img style="width: 100%;" src="/fontend/images/slider2.jpg" class="girl img-responsive" alt="Slide 2" />
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-sm-12">
                            <img style="width: 100%;" src="/fontend/images/slider3.webp" class="girl img-responsive" alt="Slide 3" />
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-sm-12">
                            <img style="width: 100%;" src="/fontend/images/slider4.webp" class="girl img-responsive" alt="Slide 4" />
                        </div>
                    </div>
                </div>
                <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian">
                            <!-- category products -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Laptop Mới</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Laptop Cũ</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Trả Góp</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="brands_products"><!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <!-- Danh sách thương hiệu sản phẩm (static example) -->
                                    <li><a href="#">MSI</a></li>
                                    <li><a href="#">HP</a></li>
                                    <li><a href="#">Dell</a></li>
                                </ul>
                            </div>
                        </div><!--/brands_products-->
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="fontendatures_items">
                        <h2 class="title text-center">Sản phẩm mới nhất</h2>
                        <div id="products-list"></div> <!-- Products will be added here -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Gọi API để lấy sản phẩm
    fetch('http://127.0.0.1:8000/api/v1/products', {
    method: 'GET'
        }   )
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể lấy sản phẩm.');
            }
            return response.json();
        })
        .then(data => {
            renderProducts(data); // Gọi hàm render để hiển thị sản phẩm
        })
        .catch(error => {
            console.log('Lỗi khi gọi API:', error);
        });

    // Hàm hiển thị sản phẩm
    const renderProducts = (products) => {
        const productsList = document.getElementById('products-list');
        productsList.innerHTML = ''; // Clear danh sách sản phẩm cũ

        // Lặp qua mỗi sản phẩm và thêm vào trang
        products.forEach(product => {
            const productItem = document.createElement('div');
            productItem.classList.add('col-sm-4');
            productItem.innerHTML = `
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                <input type="hidden" value="${product.product_id}" class="cart_product_id_${product.product_id}">
                                <input type="hidden" value="${product.product_name}" class="cart_product_name_${product.product_id}">
                                <input type="hidden" value="${product.image_url}" class="cart_product_image_${product.product_id}">
                                <input type="hidden" value="${product.price}" class="cart_product_price_${product.product_id}">
                                <input type="hidden" value="1" class="cart_product_qty_${product.product_id}">

                                <a href="#?product_id=${product.product_id}">
                                    <img src="/fontend/images/product/${product.image_url}" alt="${product.product_name}" />
                                    <h2>${new Intl.NumberFormat('vi-VN').format(product.price)} VNĐ</h2>
                                    <p>${product.product_name}</p>
                                </a>

                                <button type="button" class="btn btn-default add-to-cart" data-id_product="${product.product_id}" name="add-to-cart">
                                    <i class="fa fa-shopping-cart"></i> Thêm giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            productsList.appendChild(productItem);
        });
    };
</script>
@endsection
