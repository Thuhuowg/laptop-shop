const urlParams = new URLSearchParams(window.location.search);
const productId = urlParams.get('id'); // Lấy ID sản phẩm từ URL

// Hàm tải chi tiết sản phẩm
const loadProductDetails = async () => {
    if (!productId) {
        alert('Không tìm thấy ID sản phẩm!');
        return;
    }

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/v1/products/${productId}`);
        if (!response.ok) {
            throw new Error('Sản phẩm không tìm thấy');
        }
        const data = await response.json();
        if (data.status === 'success') {
            displayProductDetails(data.data, data.categories, data.discounts); // Cập nhật để truyền dữ liệu đúng
        } else {
            alert('Không thể tải thông tin sản phẩm');
        }
    } catch (error) {
        console.error('Lỗi khi tải thông tin sản phẩm:', error);
        alert('Không tìm thấy sản phẩm hoặc có lỗi trong việc tải thông tin');
    }
};

// Hàm hiển thị thông tin sản phẩm
const displayProductDetails = (product, categories, discounts) => {
    const productDetails = document.querySelector('.product-details');
    if (product) {
        productDetails.innerHTML = `
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="${product.image_url ? '/fontend/images/product/' + product.image_url : '/fontend/images/no-image.png'}" alt="${product.product_name}" />
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information">
                    <h1>Chi Tiết Sản Phẩm</h1>
                    <h2>${product.product_name}</h2>
                    <p><strong>Mã sản phẩm</strong>: ${product.product_id}</p>
                    <p><strong>Mô tả sản phẩm</strong>: ${product.description}</p>
                    <span>
                        <span>${new Intl.NumberFormat('vi-VN').format(product.price)} VNĐ</span>
                        <label>Số lượng:</label>
                        <input class="cart_product_qty_${product.product_id}" name="qty" type="number" min="1" value="1" />
                        <button type="button" class="btn btn-default cart add-to-cart" data-id_product="${product.product_id}">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                    </span>
                    <p><b>Tình trạng:</b> ${product.is_deleted === 0 ? 'Còn hàng' : 'Hết hàng'}</p>
                    <p><b>Danh mục:</b> ${product.category ? product.category.category_name : 'Không có'}</p>
                    <p><b>Giảm giá:</b> ${product.discount ? product.discount.discount_percent + '% giảm' : 'Không có'}</p>
                </div>
            </div>
        `;
    } else {
        console.error('Dữ liệu sản phẩm bị thiếu');
    }
};

// Hàm thêm sản phẩm vào giỏ hàng
const addToCart = (productId, quantity) => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    const existingProductIndex = cart.findIndex(item => item.product_id === productId);

    if (existingProductIndex > -1) {
        // Nếu sản phẩm đã có, cập nhật số lượng
        cart[existingProductIndex].quantity += quantity;
    } else {
        // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
        const newProduct = {
            product_id: productId,
            quantity: quantity
        };
        cart.push(newProduct);
    }

    // Lưu giỏ hàng vào localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    // Cập nhật lại số lượng giỏ hàng
    updateCartCount();
};

// Cập nhật số lượng sản phẩm trong giỏ
const updateCartCount = () => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector(".cart-count").innerText = totalItems;
};

// Thêm sự kiện cho nút "Thêm giỏ hàng"
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('add-to-cart')) {
        const productId = event.target.dataset.id_product;
        const quantityInput = document.querySelector(`.cart_product_qty_${productId}`);
        const quantity = parseInt(quantityInput.value) || 1; // Lấy số lượng từ input

        addToCart(productId, quantity);
        alert('Sản phẩm đã được thêm vào giỏ hàng!');
    }
});

// Gọi hàm để tải thông tin sản phẩm
loadProductDetails();