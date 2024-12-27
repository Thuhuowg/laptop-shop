  <!-- Kế thừa layout.blade.php -->

<?php $__env->startSection('title', 'Chi tiết sản phẩm | Laptop-Shoppe'); ?>  <!-- Tiêu đề trang -->

<?php $__env->startSection('content'); ?>
<section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-details">
                        <!-- Thông tin sản phẩm sẽ được thêm vào đây -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/fontend/js/pddetail.js"></script>
    

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laptop-shop\giaodien\resources\views/product-detail.blade.php ENDPATH**/ ?>