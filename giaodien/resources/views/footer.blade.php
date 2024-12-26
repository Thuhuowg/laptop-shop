@extends('layout.layout')  <!-- Kế thừa layout.blade.php -->

@section('content')
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>Laptop</span>-shoppe</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="/san-pham">
                                <div class="iframe-img">
                                    <img src="/fe/images/footer1.webp" alt="Footer Image">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="/fe/images/map.png" alt="Address Map">
                        <p>Km 10, đường Nguyễn Trãi, quận Thanh Xuân, Hà Nội</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2024 Laptop-Shoppe. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
@endsection