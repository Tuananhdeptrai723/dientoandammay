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

function updateCart() {
  cartItems.innerHTML = "";
  totalPrice = 0;
  cart.forEach((item) => {
    const li = document.createElement("li");
    li.textContent = `${item.name} - $${item.price}`;
    cartItems.appendChild(li);
    totalPrice += item.price;
  });
  total.textContent = `Tổng: $${totalPrice.toFixed(2)}`;
}

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

function addToCartClicked(productId) {
  $.ajax({
    url: "../View/ConnectDb.php",
    type: "POST",
    data: { productId: productId },
    success: function () {
      console.log("success");
      showCartNotification();
    },
    error: function (xhr, status, error) {
      console.log("error");
      console.log("Product ID:", productId);
    },
  });
}
