document.addEventListener("DOMContentLoaded", function () {
    // Lấy giỏ hàng từ localStorage và tính tổng số tiền
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalAmount = 0;

    cart.forEach(item => {
        totalAmount += item.price * item.quantity; // Giả sử có thuộc tính price và quantity trong item
    });

    document.getElementById('total-amount').textContent = totalAmount.toLocaleString() + ' VND';

    const paymentMethodSelect = document.getElementById('payment-method');
    const vnpayBtn = document.getElementById('vnpay-btn');
    const codBtn = document.getElementById('cod-btn');

    paymentMethodSelect.addEventListener('change', function () {
        const selectedMethod = paymentMethodSelect.value;
        if (selectedMethod === 'vnpay') {
            vnpayBtn.style.display = 'inline-block';
            codBtn.style.display = 'none';
        } else if (selectedMethod === 'cash') {
            codBtn.style.display = 'inline-block';
            vnpayBtn.style.display = 'none';
        } else {
            vnpayBtn.style.display = 'none';
            codBtn.style.display = 'none';
        }
    });

    vnpayBtn.addEventListener('click', function () {
        handleVNPayPayment();
    });

    codBtn.addEventListener('click', function () {
        handleCODPayment();
    });

    function handleVNPayPayment() {
        const amount = document.getElementById('amount').value;

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
                    window.location.href = data.data; // Redirect đến VNPay URL
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
        alert('Đơn hàng của bạn đã được tạo. Vui lòng thanh toán khi nhận hàng.');
        document.getElementById('message').textContent = 'Thanh toán COD thành công.';
    }
});
document.getElementById('submit-button').addEventListener('click', function () {
    const data = {
        order_id: document.getElementById('order_id').value,
        payment_method: document.getElementById('payment_method').value,
        payment_status: document.getElementById('payment_status').value,
        amount: document.getElementById('amount').value
    };
    fetch('http://127.0.0.1:8002/api/payments/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thanh toán đã được tạo thành công!');
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Không thể kết nối đến API.');
        });
    // Gửi dữ liệu đến backend

});