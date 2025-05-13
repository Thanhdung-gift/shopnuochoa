// Lưu sản phẩm vào localStorage
function addToCart(name, price) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Kiểm tra nếu sản phẩm đã tồn tại, tăng số lượng
    let existingProduct = cart.find(item => item.name === name);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ name, price, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartQuantity();
}

// Cập nhật số lượng sản phẩm hiển thị ở icon giỏ hàng
function updateCartQuantity() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const total = cart.reduce((sum, item) => sum + item.quantity, 0);
    const totalQuality = document.querySelector(".totalQuality");
    if (totalQuality) totalQuality.innerText = total;
}

// Gọi hàm cập nhật khi trang được tải
document.addEventListener("DOMContentLoaded", updateCartQuantity);
