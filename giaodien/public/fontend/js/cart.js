// Hàm hiển thị giỏ hàng
const renderCartItems = () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    if (cartItems && cartTotal) {
        cartItems.innerHTML = ''; // Xóa nội dung cũ
        let total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="/fontend/images/product/${item.image_url}" alt="${item.product_name}" width="50"></td>
                <td>${item.product_name}</td>
                <td>${new Intl.NumberFormat('vi-VN').format(item.price)} VNĐ</td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input">
                </td>
                <td>${new Intl.NumberFormat('vi-VN').format(itemTotal)} VNĐ</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Xóa</button>
                </td>
            `;
            cartItems.appendChild(row);
        });

        cartTotal.textContent = `Tổng: ${new Intl.NumberFormat('vi-VN').format(total)} VNĐ`;
    } else {
        console.error("Không tìm thấy phần tử cần thiết để hiển thị giỏ hàng.");
    }
};

// Cập nhật số lượng sản phẩm
const updateQuantity = (index, quantity) => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart[index]) {
        cart[index].quantity = quantity;
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
const removeItem = (index) => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1); // Xóa sản phẩm tại vị trí index
    localStorage.setItem('cart', JSON.stringify(cart));
    updateHeaderCartCount();
    renderCartItems();
};

// Lắng nghe sự kiện thay đổi số lượng
document.addEventListener('input', (event) => {
    if (event.target && event.target.classList.contains('quantity-input')) {
        const index = event.target.getAttribute('data-index');
        const quantity = parseInt(event.target.value);
        if (quantity > 0) {
            updateQuantity(index, quantity);
        } else {
            alert('Số lượng phải lớn hơn 0!');
            event.target.value = 1; // Đặt lại số lượng về 1 nếu nhập không hợp lệ
        }
    }
});

// Lắng nghe sự kiện xóa sản phẩm
document.addEventListener('click', (event) => {
    if (event.target && event.target.classList.contains('remove-item')) {
        const index = event.target.getAttribute('data-index');
        removeItem(index);
    }
});

// Hiển thị giỏ hàng khi tải trang
document.addEventListener('DOMContentLoaded', () => {
    renderCartItems();
    updateHeaderCartCount(); // Cập nhật số lượng giỏ hàng khi tải trang
});