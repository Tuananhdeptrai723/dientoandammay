const addToCartButtons = document.querySelectorAll('.add-to-cart');
const cartItems = document.querySelector('.cart-items');
const total = document.querySelector('.total');
let cart = [];
let totalPrice = 0;

addToCartButtons.forEach(button => {
  button.addEventListener('click', () => {
    const menuItem = button.parentNode;
    const name = menuItem.querySelector('h3').textContent;
    const price = parseFloat(menuItem.querySelector('.price').textContent.replace('$', ''));
    const item = { name, price };
    cart.push(item);
    updateCart();
  });
});

function updateCart() {
  cartItems.innerHTML = '';
  totalPrice = 0;
  cart.forEach(item => {
    const li = document.createElement('li');
    li.textContent = `${item.name} - $${item.price}`;
    cartItems.appendChild(li);
    totalPrice += item.price;
  });
  total.textContent = `Tổng: $${totalPrice.toFixed(2)}`;
}