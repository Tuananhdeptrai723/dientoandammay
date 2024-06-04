const addToCartButtons = document.querySelectorAll(".add-to-cart");
const cartItems = document.querySelector(".cart-items");
const total = document.querySelector(".total");
let cart = [];
let totalPrice = 0;

addToCartButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const menuItem = button.parentNode;
    const name = menuItem.querySelector("h3").textContent;
    const price = parseFloat(
      menuItem.querySelector(".price").textContent.replace("$", "")
    );
    const item = { name, price };
    cart.push(item);
    updateCart();
  });
});

const productsPerPage = 3;
let currentPage = 1;
const menuItems = document.querySelectorAll(".menu-item");
const totalPages = Math.ceil(menuItems.length / productsPerPage);

function showPage(page) {
  const startIndex = (page - 1) * productsPerPage;
  const endIndex = startIndex + productsPerPage;

  menuItems.forEach((item, index) => {
    if (index >= startIndex && index < endIndex) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });

  document.querySelector(".current-page").textContent = page;
}

document.querySelector(".prev-page").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
  }
});

document.querySelector(".next-page").addEventListener("click", () => {
  if (currentPage < totalPages) {
    currentPage++;
    showPage(currentPage);
  }
});

showPage(1);

function updateCart(productId, productName, productPrice, quantity) {
  // Tìm phần tử giỏ hàng
  const cartItems = document.querySelector(".cart-items");

  // Tìm sản phẩm trong giỏ hàng (nếu có)
  const cartItem = document.querySelector(
    `.cart-item[data-product-id="${productId}"]`
  );

  if (cartItem) {
    // Cập nhật số lượng và tổng tiền cho sản phẩm đã có trong giỏ hàng
    const quantityElement = cartItem.querySelector(".quantity");
    const totalElement = cartItem.querySelector(".total");
    const newQuantity = parseInt(quantityElement.textContent) + quantity;
    const newTotal = newQuantity * productPrice;
    quantityElement.textContent = newQuantity;
    totalElement.textContent = `$${newTotal.toFixed(2)}`;
  } else {
    // Tạo phần tử HTML cho sản phẩm mới trong giỏ hàng
    const cartItemElement = document.createElement("li");
    cartItemElement.classList.add("cart-item");
    cartItemElement.dataset.productId = productId;
    cartItemElement.innerHTML = `
      <span class="product-name">${productName}</span>
      <span class="quantity">${quantity}</span>
      <span class="price">$${productPrice.toFixed(2)}</span>
      <span class="total">$${(quantity * productPrice).toFixed(2)}</span>
      <button class="remove-from-cart">Xóa</button>
    `;
    cartItems.appendChild(cartItemElement);
  }

  // Cập nhật tổng số tiền trong giỏ hàng
  updateTotalPrice();
}

function showCartNotification() {
  const notification = document.createElement("div");
  notification.classList.add("cart-notification");
  notification.textContent = "Sản phẩm đã được thêm vào giỏ hàng";
  document.body.appendChild(notification);

  setTimeout(() => {
    notification.classList.add("show");
  }, 100);

  setTimeout(() => {
    notification.classList.remove("show");
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 500);
  }, 3000);
}
