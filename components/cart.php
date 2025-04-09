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
                    <p>Total Quantity</p>
                    <hr class="carthr" />
                    <p>Total Price</p>
                    <hr class="carthr" />
                </div>
                <div>
                    <p id="subtotal">0₫</p>
                    <p id="total-quantity">0</p>
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

    <script src="../scripts/cart.js"></script>
    <script>
        document.getElementById("checkoutbut").addEventListener("click", function() {
            // Check if the user is logged in by using PHP session check.
            <?php if (isset($_SESSION["user_id"])): ?>
                // User is logged in, proceed to checkout
                const checkboxes = document.querySelectorAll('.checkout-checkbox:checked');
                const selectedItems = [];

                // Loop through checked checkboxes and add selected items to the array
                checkboxes.forEach(checkbox => {
                    const index = parseInt(checkbox.dataset.index);
                    const item = JSON.parse(localStorage.getItem('cart'))[index]; // Get the item from localStorage by index
                    selectedItems.push(item);
                });

                // If no items are selected, show an alert
                if (selectedItems.length === 0) {
                    alert("Please select at least one item to checkout.");
                    return;
                }

                // Store the selected items in localStorage for checkout
                localStorage.setItem('checkout-items', JSON.stringify(selectedItems));

                // Redirect the user to the checkout page
                window.location.href = "checkout.php";
            <?php else: ?>
                // If the user is not logged in, show an alert and redirect to the login page
                alert("Please login to continue!");
                window.location.href = "login.php";
            <?php endif; ?>
        });


        window.onload = loadCart;
    </script>
</body>

</html>