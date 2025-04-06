function loadCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartItems = document.getElementById('cart-items');
  cartItems.innerHTML = '';

  if (cart.length === 0) {
    cartItems.innerHTML = '<p>Your cart is empty.</p>';
    document.getElementById('subtotal').textContent = '0₫';
    document.getElementById('total-quantity').textContent = '0';
    return;
  }

  let subtotal = 0;
  let totalQuantity = 0;

  cart.forEach((item, index) => {
    const price = parseFloat(item.price) || 0;
    const quantity = parseInt(item.quantity) || 1;
    const itemTotal = price * quantity;
    totalQuantity += quantity;

    const itemDiv = document.createElement('div');
    itemDiv.className = 'cart-items';
    itemDiv.innerHTML = `
      <div>
          <img src="${item.image}" width="100" alt="${item.name}">
      </div>
      <div>
          <p><strong>${item.name}</strong></p>
          <p>Size: ${item.size}</p>
          <p>Price: ${formatCurrency(price)}</p>
          <div class="quantity-controls">
              <button class="decrease-btn" data-index="${index}">-</button>
              <span class="quantity">${quantity}</span>
              <button class="increase-btn" data-index="${index}">+</button>
          </div>
          <p>Total: ${formatCurrency(itemTotal)}</p>
          <button class="remove-btn" data-index="${index}">Remove</button>
      </div>
      <div>
          <input type="checkbox" class="checkout-checkbox" id="checkbox-${index}" data-index="${index}">
          <label for="checkbox-${index}"></label>
      </div>
  `;
    cartItems.appendChild(itemDiv);
    subtotal += itemTotal;
  });

  updateSummary();
}

function updateSummary() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const checkboxes = document.querySelectorAll('.checkout-checkbox:checked');

  let subtotal = 0;
  let totalQuantity = 0;
  checkboxes.forEach(checkbox => {
    const index = parseInt(checkbox.dataset.index);
    const item = cart[index];
    subtotal += (parseFloat(item.price) || 0) * (parseInt(item.quantity) || 1);
    totalQuantity += parseInt(item.quantity) || 1;
  });

  document.getElementById('subtotal').textContent = formatCurrency(subtotal);
  document.getElementById('grandtotal').textContent = formatCurrency(subtotal);
  document.getElementById('total-quantity').textContent = totalQuantity;
}

document.addEventListener('click', function (e) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  if (e.target.classList.contains('remove-btn')) {
    const index = parseInt(e.target.dataset.index);
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
  }

  if (e.target.classList.contains('increase-btn')) {
    const index = parseInt(e.target.dataset.index);
    cart[index].quantity += 1;
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
  }

  if (e.target.classList.contains('decrease-btn')) {
    const index = parseInt(e.target.dataset.index);
    if (cart[index].quantity > 1) {
      cart[index].quantity -= 1;
      localStorage.setItem('cart', JSON.stringify(cart));
      loadCart();
    }
  }

  if (e.target.classList.contains('checkout-checkbox')) {
    updateSummary();
  }
});

function formatCurrency(value) {
  return Number(value).toLocaleString('vi-VN') + '₫';
}

document.addEventListener('DOMContentLoaded', function () {
  loadCart();
});