// Gọi API để lấy danh sách sản phẩm
fetch('http://127.0.0.1:8000/api/v1/products', {
    method: 'GET'
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Không thể lấy sản phẩm.');
        }
        return response.json();
    })
    .then(data => {
        renderAvailableProducts(data.product); // Gọi hàm render để hiển thị sản phẩm
        renderCategories(data.category); // Gọi hàm để hiển thị danh mục
        renderDiscounts(data.discount); // Gọi hàm để hiển thị giảm giá
    })
    .catch(error => {
        console.log('Lỗi khi gọi API:', error);
    });

// Hàm hiển thị sản phẩm
const renderAvailableProducts = (products) => {
    const productsList = document.getElementById('products-list');
    productsList.innerHTML = ''; // Xóa danh sách sản phẩm cũ

    // Kiểm tra xem có sản phẩm nào hay không
    if (!Array.isArray(products) || products.length === 0) {
        productsList.innerHTML = '<p>Không có sản phẩm</p>';
        return;
    }

    // Lặp qua mỗi sản phẩm và thêm vào danh sách
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

                            <a href="/product-detail?id=${product.product_id}">
                                <img src="${product.image_url ? '/fontend/images/product/' + product.image_url : '/fontend/images/no-image.png'}" alt="${product.product_name}" />
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

    // Gắn sự kiện click "Thêm giỏ hàng"
    attachAddToCartEvent();
};

// Hàm hiển thị danh mục
const renderCategories = (categories) => {
    const categoryList = document.getElementById('category-list');
    categoryList.innerHTML = ''; // Xóa danh sách danh mục cũ

    categories.forEach(category => {
        const categoryItem = document.createElement('option');
        categoryItem.value = category.category_id;
        categoryItem.innerText = category.category_name;
        categoryList.appendChild(categoryItem);
    });
};

// Hàm hiển thị giảm giá
const renderDiscounts = (discounts) => {
    const discountList = document.getElementById('discount-list');
    discountList.innerHTML = ''; // Xóa danh sách giảm giá cũ

    discounts.forEach(discount => {
        const discountItem = document.createElement('option');
        discountItem.value = discount.discount_id;
        discountItem.innerText = `${discount.discount_name} (${discount.discount_percent}%)`;
        discountList.appendChild(discountItem);
    });
};

// Gắn sự kiện click "Thêm giỏ hàng"
const attachAddToCartEvent = () => {
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", (event) => {
            const productId = button.getAttribute("data-id_product");
            const productName = document.querySelector(`.cart_product_name_${productId}`).value;
            const price = parseFloat(document.querySelector(`.cart_product_price_${productId}`).value);
            const imageUrl = document.querySelector(`.cart_product_image_${productId}`).value;
            const quantity = parseInt(document.querySelector(`.cart_product_qty_${productId}`).value);

            const product = {
                product_id: productId,
                product_name: productName,
                price: price,
                image_url: imageUrl,
                quantity: quantity
            };

            addToCart(product);
        });
    });
};

// Hàm thêm sản phẩm vào giỏ hàng
const addToCart = (product) => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    const existingProductIndex = cart.findIndex(item => item.product_id === product.product_id);
    if (existingProductIndex !== -1) {
        cart[existingProductIndex].quantity += product.quantity;
    } else {
        cart.push(product);
    }

    // Lưu giỏ hàng vào localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Sản phẩm đã được thêm vào giỏ hàng!');
    updateCartCount();
};

// Hàm tải chi tiết sản phẩm
const loadProductDetails = async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id'); // Lấy ID sản phẩm từ URL

    if (!productId) {
        return;
    }

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/v1/products/${productId}`);
        if (!response.ok) {
            throw new Error('Sản phẩm không tìm thấy');
        }
        const data = await response.json();
        displayProductDetails(data.product, data.category, data.discount); // Cập nhật để truyền dữ liệu đúng
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

// Gọi hàm tải chi tiết sản phẩm
loadProductDetails();

// Thêm sự kiện lọc sản phẩm
const addFilterEvent = () => {
    document.getElementById('filter-btn').addEventListener('click', async function () {
        const category_id = document.getElementById('category_id').value;
        const price = document.getElementById('price').value;

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/v1/filter-products?category_id=${category_id}&price=${price}`);
            const products = await response.json();
            renderAvailableProducts(products); // Cập nhật danh sách sản phẩm sau khi lọc
        } catch (error) {
            console.error('Lỗi khi lọc sản phẩm:', error);
            const productsList = document.getElementById('products-list');
            productsList.innerHTML = '<p>Đã có lỗi khi tải sản phẩm. Vui lòng thử lại sau.</p>';
        }
    });
};

// Gọi sự kiện lọc
addFilterEvent();