<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style/footer.css" />
    <link rel="stylesheet" href="../style/navbar.css" />
    <link rel="stylesheet" href="../style/cart.css" />
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet" />
    <title>Nike, Just Do It. Nike.com</title>
</head>

<body>
    <div id="top_bar">
        <div class="top">
            <?php include 'top.php'; ?>
        </div>
        <div class="bottom">
            <?php include 'bottom.php'; ?>
        </div>
    </div>
    <div id="cart-main">
        <div id="cart-div">
            <h2>🛒 Your Cart</h2>
            <div id="cart-items"></div>
        </div>

        <div id="cart-summary">
            <p>Summary</p>
            <div id="cart-total">
                <div>
                    <p>Subtotal</p>
                    <p>Estimated Delivery</p>
                    <hr class="carthr" />
                    <p>Total</p>
                    <hr class="carthr" />
                </div>
                <div>
                    <p id="subtotal">0₫</p>
                    <p>150₫</p>
                    <hr class="carthr" />
                    <p id="grandtotal">0₫</p>
                    <hr class="carthr" />
                </div>
            </div>
            <div id="cart-checkout">
                <button id="checkoutbut">Checkout</button>
            </div>
        </div>
    </div>

    <script>
        function formatCurrency(value) {
            return Number(value).toLocaleString('vi-VN') + '₫';
        }

        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = '';

            if (cart.length === 0) {
                cartItems.innerHTML = '<p>Your cart is empty.</p>';
                document.getElementById('subtotal').textContent = '0₫';
                document.getElementById('grandtotal').textContent = '150₫';
                return;
            }

            let subtotal = 0;

            cart.forEach((item, index) => {
                const price = parseFloat(item.price) || 0;
                const quantity = parseInt(item.quantity) || 1;
                const itemTotal = price * quantity;
                subtotal += itemTotal;

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
                    <p>Total: ${formatCurrency(itemTotal)}</p>
                    <div class="quantity-controls">
                        <button class="decrease-btn" data-index="${index}">-</button>
                        <span class="quantity">${quantity}</span>
                        <button class="increase-btn" data-index="${index}">+</button>
                    </div>
                    <button class="remove-btn" data-index="${index}">Remove</button>
                </div>
            `;
                cartItems.appendChild(itemDiv);
            });

            document.getElementById('subtotal').textContent = formatCurrency(subtotal);
            document.getElementById('grandtotal').textContent = formatCurrency(subtotal + 150);
        }

        document.addEventListener('click', function(e) {
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
        });

        window.onload = loadCart;
    </script>

</body>

</html>