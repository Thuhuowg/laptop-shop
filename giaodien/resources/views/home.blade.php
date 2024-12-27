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
                        <form id="filter-form">
        <!-- Lọc thương hiệu -->
        <div class="brands_products">
            <h4>Thương hiệu</h4>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Tất cả</option>
                <option value="4">MSI</option>
                <option value="1">HP</option>
                <option value="3">Dell</option>
                <option value="2">Lenovo</option>
            </select>
        </div>

        <!-- Lọc giá -->
        <div class="filter-price">
            <h4>Khoảng giá</h4>
            <select name="price" id="price" class="form-control">
                <option value="">Tất cả</option>
                <option value="0-5000000">Dưới 5 triệu</option>
                <option value="5000000-10000000">5 - 10 triệu</option>
                <option value="10000000-20000000">10 - 20 triệu</option>
                <option value="20000000-50000000">20 - 50 triệu</option>
            </select>
        </div>

        <button type="button" id="filter-btn" class="btn btn-primary" style="margin-top: 15px;">Áp dụng</button>
    </form>
                        
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
