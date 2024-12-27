document.addEventListener("DOMContentLoaded", function () {
    // Lấy giỏ hàng và tính tổng tiền
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalAmount = 0;
    cart.forEach(item => {
        totalAmount += item.price * item.quantity;
    });
    document.getElementById('total-amount').textContent = totalAmount.toLocaleString() + ' VND';

    const paymentMethodSelect = document.getElementById('payment-method');
    const paymentOptions = document.getElementById('payment-options');
    const vnpayBtn = document.getElementById('vnpay-btn');
    const codBtn = document.getElementById('cod-btn');

    paymentMethodSelect.addEventListener('change', function () {
        const selectedMethod = paymentMethodSelect.value;
        if (selectedMethod === 'VNPay') {
            paymentOptions.style.display = 'block'; // Hiện chỉ nút VNPay
            vnpayBtn.style.display = 'inline-block';
            codBtn.style.display = 'none'; // Ẩn nút COD
        } else if (selectedMethod === 'COD') {
            paymentOptions.style.display = 'block'; // Hiện nút COD
            codBtn.style.display = 'inline-block';
            vnpayBtn.style.display = 'none'; // Ẩn nút VNPay
        } else {
            paymentOptions.style.display = 'none'; // Ẩn tất cả
        }
    });

    vnpayBtn.addEventListener('click', function () {
        handleVNPayPayment();
    });

    codBtn.addEventListener('click', function () {
        handleCODPayment();
    });

    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const address = document.getElementById('address').value;
        const phone = document.getElementById('phone').value;
        const paymentMethod = paymentMethodSelect.value;

        // Tạo đơn hàng
        const orderData = {
            email: email,
            customer_name: name,
            address: address,
            phone: phone,
            payment_method: paymentMethod,
            total_amount: totalAmount,
            status: 'pending'
        };

        fetch('http://localhost:8004/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData),
        })
        .then(response => response.json())
        .then(order => {
            alert('Đơn hàng đã được tạo thành công!');
            localStorage.removeItem("cart");
        })
        .catch(error => {
            console.error('Error creating order:', error);
        });
    });

    function handleVNPayPayment() {
        console.log('Hàm thanh toán VNPay được gọi');
        const amount = totalAmount;

        if (!amount || amount <= 0) {
            document.getElementById('message').textContent = 'Vui lòng nhập số tiền hợp lệ!';
            return;
        }

        fetch('http://localhost:8003/api/payment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ amount: amount, method: 'vnpay' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.code === '00') {
                localStorage.removeItem("cart");
                window.location.assign(data.data);
            } else {
                document.getElementById('message').textContent = 'Lỗi: ' + data.message;
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            document.getElementById('message').textContent = 'Đã xảy ra lỗi, vui lòng thử lại.';
        });
    }

    function handleCODPayment() {
        console.log('Hàm thanh toán COD được gọi');
        localStorage.removeItem("cart");
        window.location.href = "/thankyou"; // Đường dẫn đến trang Thank You
    }
});