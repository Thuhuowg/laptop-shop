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
                        <img style="width: 100%;" src="/fontend/images/slider1.webp" class="girl img-responsive"
                            alt="Slide 1" />
                    </div>
                </div>
                <div class="item">
                    <div class="col-sm-12">
                        <img style="width: 100%;" src="/fontend/images/slider2.jpg" class="girl img-responsive"
                            alt="Slide 2" />
                    </div>
                </div>
                <div class="item">
                    <div class="col-sm-12">
                        <img style="width: 100%;" src="/fontend/images/slider3.webp" class="girl img-responsive"
                            alt="Slide 3" />
                    </div>
                </div>
                <div class="item">
                    <div class="col-sm-12">
                        <img style="width: 100%;" src="/fontend/images/slider4.webp" class="girl img-responsive"
                            alt="Slide 4" />
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
                                <label class="checkbox-item">
                                    <input type="checkbox" class="filter-category-checkbox" value="1"> Laptop HP
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" class="filter-category-checkbox" value="2"> Laptop Lenovo
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" class="filter-category-checkbox" value="3"> Latop Dell
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" class="filter-category-checkbox" value="4"> Latop MSI
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" class="filter-category-checkbox" value="5"> Latop
                                </label>
                            </ul>
                        </div>
                    </div><!--/brands_products-->
                    <div class="brands_products"><!--brands_products-->
                        <h2>Mức giá sản phẩm</h2>
                        <div class="filter-price ">
                            <label class="checkbox-item">
                                <input type="checkbox" class="filter-price-checkbox" value="0-10"> 0 - 10 triệu
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" class="filter-price-checkbox" value="10-20"> 10 - 20 triệu
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" class="filter-price-checkbox" value="20-50"> 20 - 50 triệu
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" class="filter-price-checkbox" value="50-100"> 50 - 100 triệu
                            </label>
                        </div>
                    </div><!--/brands_products-->
                    <button id="apply-filters" class="btn btn-primary">Áp dụng bộ lọc</button>
                </div>
            </div>

            <div class="container">
    <h2>Kết quả tìm kiếm cho: "{{ $query }}"</h2>
    <div class="row">
        @if($products->isEmpty())
            <p>Không tìm thấy sản phẩm nào.</p>
        @else
            @foreach($products as $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <a href="/product-detail?id={{ $product->product_id }}">
                                    <img src="{{ $product->image_url ? '/fontend/images/product/' . $product->image_url : '/fontend/images/no-image.png' }}" alt="{{ $product->product_name }}" />
                                    <h2>{{ number_format($product->price) }} VNĐ</h2>
                                    <p>{{ $product->product_name }}</p>
                                </a>
                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{ $product->product_id }}">
                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
        </div>
    </div>
</section>

    <!-- <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian">
                            
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
                        
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="fontendatures_items">
                        <h2 class="title text-center">Sản phẩm mới nhất</h2>
                        <div id="products-list"></div> 
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    
@endsection
