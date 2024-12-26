document.addEventListener("DOMContentLoaded", function () {
    // Load Header - bạn có thể thêm mã để tải header ở đây nếu cần

    // Lấy giỏ hàng và tính tổng tiền
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalAmount = 0;
    cart.forEach(item => {
        totalAmount += item.price * item.quantity;
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

    vnpayBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định
        handleVNPayPayment();
    });

    codBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định
        handleCODPayment();
    });

    function handleVNPayPayment() {
        console.log('Hàm thanh toán VNPay được gọi'); // Debug
        const amount = totalAmount; // Sử dụng tổng số tiền đã tính

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
            console.log('Dữ liệu phản hồi:', data); // Debug
            if (data.code === '00') {
                console.log('Chuyển hướng đến:', data.data);
                localStorage.removeItem("cart");
                window.location.assign(data.data);
            } else {
                document.getElementById('message').textContent = 'Lỗi: ' + data.message;
            }
        })
        .catch(err => {
            console.error('Lỗi:', err); // Debug
            document.getElementById('message').textContent = 'Đã xảy ra lỗi, vui lòng thử lại.';
        });
    }

    function handleCODPayment() {
        console.log('Hàm thanh toán COD được gọi'); // Debug
        localStorage.removeItem("cart");
        window.location.href = "/thankyou"; // Đường dẫn đến trang Thank You
    }
});