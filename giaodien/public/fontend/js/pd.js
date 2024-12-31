document.addEventListener('DOMContentLoaded', function () {
    // Gọi API và tải nội dung sản phẩm
    fetch('http://127.0.0.1:8000/api/v1/products')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const productGrid = document.getElementById('product-grid');

                // Duyệt qua danh sách sản phẩm
                data.data.products.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.classList.add('col-sm-3', 'product-item'); // Thêm lớp col-sm-3 để chia thành 4 cột

                    productItem.innerHTML = `
                        <div class="product">
                            <div class="product-image">
                                 <img src="${product.image_url ? '/fontend/images/product/' + product.image_url : '/fontend/images/no-image.png'}" alt="${product.product_name}" />
                            </div>
                            <div class="product-info">
                                <h3>${product.product_name}</h3>
                                <p class="product-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                            </div>
                            <a href="/product-detail?product_id=${product.product_id}" class="btn btn-primary">Xem Chi Tiết</a>
                        </div>
                    `;
                    productGrid.appendChild(productItem);
                });
            } else {
                console.error('Lỗi khi tải dữ liệu sản phẩm:', data.message);
            }
        })
        .catch(error => console.log('Lỗi khi tải sản phẩm:', error));
});