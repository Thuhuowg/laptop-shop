<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | Laptop-Shoppe</title>
    <link href="/fe/css/bootstrap.min.css" rel="stylesheet">
    <link href="/fe/css/font-awesome.min.css" rel="stylesheet">
    <link href="/fe/css/prettyPhoto.css" rel="stylesheet">
    <link href="/fe/css/price-range.css" rel="stylesheet">
    <link href="/fe/css/animate.css" rel="stylesheet">
    <link href="/fe/css/sweetalert.css" rel="stylesheet">
    <link href="/fe/css/main.css" rel="stylesheet">
    <link href="/fe/css/responsive.css" rel="stylesheet">
</head>
<body>
    <div id="header-container"></div>

    <div class="container">
        <h2 class="title text-center">Giỏ Hàng Của Bạn</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Đơn Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                    
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Sản phẩm sẽ được hiển thị ở đây -->
            </tbody>
        </table>
        <div class="text-right">
            <h3 id="cart-total">Tổng: 0 VNĐ</h3>
            <a href="/fe/checkout/checkout.html">
            <button  class="btn btn-primary" id="checkout-button">Thanh Toán</button>
        </a>
        </div>
    </div>

    <div id="footer-container"></div>

    <script>
        // Hàm hiển thị giỏ hàng
        const renderCart = () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = ''; // Xóa nội dung cũ

            let total = 0;
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><img src="/fe/images/product/${item.image}" alt="${item.name}" width="50"></td>
                    <td>${item.name}</td>
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

            document.getElementById('cart-total').textContent = `Tổng: ${new Intl.NumberFormat('vi-VN').format(total)} VNĐ`;
        };

        // Cập nhật số lượng sản phẩm
        const updateQuantity = (index, quantity) => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart[index]) {
                cart[index].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        };

        // Xóa sản phẩm khỏi giỏ hàng
        const removeItem = (index) => {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1); // Xóa sản phẩm tại vị trí index
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
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
            renderCart();
        });

        
        // document.getElementById('checkout-button').addEventListener('click', () => {
        //     window.location.href = '/fe/checkout/checkout.html';
        // });

        // Chèn Header và Footer
        
    </script>
</body>
</html>
