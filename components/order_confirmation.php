<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../style/checkout.css">
</head>
<body>
    <h1>Checkout</h1>
    <div id="checkout-items"></div>
    <p id="total-price">Total: 0₫</p>
    <form id="checkout-form" action="order_confirmation.php" method="POST">
        <input type="hidden" name="order_data" id="order-data">
        <button type="submit">Confirm Order</button>
    </form>
    
    <script>
        function formatCurrency(value) {
            return Number(value).toLocaleString('vi-VN') + '₫';
        }
        
        function loadCheckout() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let checkoutItems = document.getElementById('checkout-items');
            let totalPrice = 0;
            checkoutItems.innerHTML = '';

            cart.forEach(item => {
                let itemTotal = item.price * item.quantity;
                totalPrice += itemTotal;
                checkoutItems.innerHTML += `
                    <div class="checkout-item">
                        <img src="${item.image}" width="100" alt="${item.name}">
                        <p><strong>${item.name}</strong></p>
                        <p>Size: ${item.size}</p>
                        <p>Price: ${formatCurrency(item.price)}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Total: ${formatCurrency(itemTotal)}</p>
                    </div>
                `;
            });
            
            document.getElementById('total-price').textContent = 'Total: ' + formatCurrency(totalPrice);
            document.getElementById('order-data').value = JSON.stringify(cart);
        }
        
        window.onload = loadCheckout;
    </script>
</body>
</html>
