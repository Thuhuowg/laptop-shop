// Hàm lấy thông tin sản phẩm từ API
const fetchProductDetails = async (productId) => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/v1/products/${productId}`);
        if (!response.ok) {
            throw new Error('Không thể lấy thông tin sản phẩm.');
        }
        const data = await response.json();
        return data.data; // Trả về thông tin sản phẩm
    } catch (error) {
        console.error('Lỗi khi lấy thông tin sản phẩm:', error);
        return null; // Trả về null nếu có lỗi
    }
};

// Hàm hiển thị giỏ hàng
const renderCartItems = async () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    if (cartItems && cartTotal) {
        cartItems.innerHTML = ''; // Xóa nội dung cũ
        let total = 0;

        for (const item of cart) {
            const productDetails = await fetchProductDetails(item.product_id);
            if (productDetails) {
                const itemTotal = productDetails.price * item.quantity;
                total += itemTotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><img src="${productDetails.image_url ? '/fontend/images/product/' + productDetails.image_url : '/fontend/images/no-image.png'}" alt="${productDetails.product_name}" width="50"></td>
                    <td>${productDetails.product_name}</td>
                    <td>${new Intl.NumberFormat('vi-VN').format(productDetails.price)} VNĐ</td>
                    <td>
                        <input type="number" min="1" value="${item.quantity}" data-id="${item.product_id}" class="quantity-input">
                    </td>
                    <td>${new Intl.NumberFormat('vi-VN').format(itemTotal)} VNĐ</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item" data-id="${item.product_id}">Xóa</button>
                    </td>
                `;
                cartItems.appendChild(row);
            }
        }

        cartTotal.textContent = `Tổng: ${new Intl.NumberFormat('vi-VN').format(total)} VNĐ`;
    } else {
        console.error("Không tìm thấy phần tử cần thiết để hiển thị giỏ hàng.");
    }
};

// Cập nhật số lượng sản phẩm
const updateQuantity = (productId, quantity) => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const itemIndex = cart.findIndex(item => item.product_id === productId);
    if (itemIndex !== -1) {
        cart[itemIndex].quantity = quantity;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateHeaderCartCount();
        renderCartItems();
    }
};

// Cập nhật số lượng sản phẩm trong giỏ hàng
const updateHeaderCartCount = () => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector(".cart-count").innerText = totalItems;
};

// Xóa sản phẩm khỏi giỏ hàng
const removeItem = (productId) => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.product_id !== productId); // Xóa sản phẩm
    localStorage.setItem('cart', JSON.stringify(cart));
    updateHeaderCartCount();
    renderCartItems();
};

// Lắng nghe sự kiện thay đổi số lượng
document.addEventListener('input', (event) => {
    if (event.target && event.target.classList.contains('quantity-input')) {
        const productId = event.target.getAttribute('data-id');
        const quantity = parseInt(event.target.value);
        if (quantity > 0) {
            updateQuantity(productId, quantity);
        } else {
            alert('Số lượng phải lớn hơn 0!');
            event.target.value = 1; // Đặt lại số lượng về 1 nếu nhập không hợp lệ
        }
    }
});

// Lắng nghe sự kiện xóa sản phẩm
document.addEventListener('click', (event) => {
    if (event.target && event.target.classList.contains('remove-item')) {
        const productId = event.target.getAttribute('data-id');
        removeItem(productId);
    }
});

// Hiển thị giỏ hàng khi tải trang
document.addEventListener('DOMContentLoaded', () => {
    renderCartItems();
    updateHeaderCartCount(); // Cập nhật số lượng giỏ hàng khi tải trang
});