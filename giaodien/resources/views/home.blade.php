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
