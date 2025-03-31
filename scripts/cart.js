function loadCart() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let cartContainer = document.getElementById("cart-div");
  cartContainer.innerHTML = ""; 

  let totalPrice = 0;

  cart.forEach((item, index) => {
      let itemPrice = parseFloat(item.price) || 0;
      let itemTotal = itemPrice * item.quantity;
      totalPrice += itemTotal;

      cartContainer.innerHTML += `
          <div class="cart-items">
              <img src="${item.image}" alt="${item.name}">
              <div>
                  <p><strong>${item.name}</strong></p>
                  <p>${item.description}</p>
                  <p>Size: ${item.size}</p>
                  <p>Price: ${itemPrice.toLocaleString()}₫</p>
                  <div class="quantity-controls">
                      <button onclick="updateQuantity(${index}, -1)">-</button>
                      <span>${item.quantity}</span>
                      <button onclick="updateQuantity(${index}, 1)">+</button>
                  </div>
              </div>
              <p>Total: ${itemTotal.toLocaleString()}₫</p>
          </div>
      `;
  });

  document.getElementById("cart-total").innerHTML = `Total: ${totalPrice.toLocaleString()}₫`;
}

function updateQuantity(index, change) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart[index].quantity += change;
  if (cart[index].quantity <= 0) cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}
