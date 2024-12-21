document.getElementById('loginForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const errorMessage = document.getElementById('errorMessage');

    errorMessage.textContent = '';

    // // Kiểm tra mật khẩu
    // const passwordRegex = /^(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\\d!@#$%^&*(),.?":{}|<>]{6,}$/;
    // if (!passwordRegex.test(password)) {
    //     errorMessage.textContent = 'Mật khẩu phải có ít nhất 6 ký tự và chứa ít nhất 1 ký tự đặc biệt.';
    //     return;
    // }

    // const payload = {
    //     email,
    //     password,
    // };

    try {
        const response = await fetch('http://127.0.0.1:8000/api/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        // Kiểm tra trạng thái HTTP
        if (!response.ok) {
            const errorData = await response.json().catch(() => null);
            errorMessage.textContent = errorData?.message || 'Đăng nhập thất bại!';
            return;
        }

        const data = await response.json();

        if (data.token && data.id && data.role) {
            // Lưu token vào cookie
            document.cookie = `token=${data.token}; path=/; SameSite=Lax; Secure; max-age=86400`;

            // Lưu thông tin người dùng vào localStorage
            localStorage.setItem('user_id', data.id);
            localStorage.setItem('role_id', data.role);

            // Chuyển hướng dựa trên vai trò
            const redirectUrl = data.role === 2 ? '../product/product.html' : '../home/home.html';
            window.location.href = redirectUrl;
        } else {
            errorMessage.textContent = 'Phản hồi từ server không hợp lệ!';
        }
    } catch (error) {
        console.error('Error:', error);
        errorMessage.textContent = 'Đã xảy ra lỗi khi đăng nhập. Vui lòng kiểm tra kết nối và thử lại.';
    }
});
