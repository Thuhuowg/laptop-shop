function initializeHeader() {
    // Function to delete a cookie by name
    function deleteCookie(name) {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
    }

    // Function to check if a token exists
    function getToken() {
        const cookieString = document.cookie.split('; ').find(row => row.startsWith('token='));
        return cookieString ? cookieString.split('=')[1] : null;
    }

    // Function to handle logout
    function handleLogout() {
        deleteCookie('token');
        localStorage.removeItem('user_id');
        localStorage.removeItem('username'); // Xóa tên người dùng
        updateAuthLink(); // Cập nhật lại liên kết đăng nhập/đăng xuất
        window.location.href = '/'; // Chuyển hướng về trang chủ sau khi đăng xuất
    }

    // Function to update the auth link based on token presence
    function updateAuthLink() {
        const authLink = document.getElementById('auth-link');
        if (!authLink) {
            console.error("Element with ID 'auth-link' not found in DOM.");
            return;
        }

        const token = getToken();
        if (token) {
            authLink.textContent = 'Đăng xuất';
            authLink.href = '../login/login.html';
            authLink.addEventListener('click', function () {
                handleLogout();
            });
        } else {
            authLink.textContent = 'Đăng nhập';
            authLink.href = '../login/login.html'; // Đường dẫn đến trang đăng nhập
            authLink.removeEventListener('click', handleLogout); // Xóa sự kiện đăng xuất nếu có
        }
    }

    // Call the function to update the link
    updateAuthLink();
}

// Ensure the function runs after header.html is loaded into the DOM
document.addEventListener('DOMContentLoaded', initializeHeader);
const updateCartCount = () => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector(".cart-count").innerText = totalItems;
};

// Cập nhật ngay khi tải trang
updateCartCount();