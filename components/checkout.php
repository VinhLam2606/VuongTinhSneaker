<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
    $_SESSION['checkout_items'] = json_decode($_POST['cart_data'], true);
    header('Location: order_confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../style/checkout.css">
</head>
<body>
    <h2>Checkout</h2>
    <div id="checkout-items"></div>
    <p>Total: <span id="checkout-total">0₫</span></p>
    <form id="checkout-form" method="POST">
        <input type="hidden" name="cart_data" id="cart_data">
        <button type="submit">Confirm Order</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let selectedItems = JSON.parse(localStorage.getItem('selectedCheckoutItems')) || [];
            let checkoutItemsDiv = document.getElementById('checkout-items');
            let total = 0;
            let selectedCart = [];
            
            selectedItems.forEach(index => {
                let item = cart[index];
                if (item) {
                    total += item.price * item.quantity;
                    selectedCart.push(item);
                    checkoutItemsDiv.innerHTML += `
                        <div class="checkout-item">
                            <img src="${item.image}" width="100" alt="${item.name}">
                            <p><strong>${item.name}</strong></p>
                            <p>Size: ${item.size}</p>
                            <p>Quantity: ${item.quantity}</p>
                            <p>Price: ${item.price.toLocaleString()}₫</p>
                        </div>
                    `;
                }
            });

            document.getElementById('checkout-total').textContent = total.toLocaleString() + '₫';
            document.getElementById('cart_data').value = JSON.stringify(selectedCart);
        });
    </script>
</body>
</html>
