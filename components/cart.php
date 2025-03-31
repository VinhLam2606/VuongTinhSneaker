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
                    <p>30.000₫</p>
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
            const checkboxes = document.querySelectorAll('.checkout-checkbox:checked');
            const selectedItems = [];

            checkboxes.forEach(checkbox => {
                const index = parseInt(checkbox.dataset.index);
                selectedItems.push(index);
            });

            if (selectedItems.length === 0) {
                alert("Please select at least one item to checkout.");
                return;
            }

            <?php if (isset($_SESSION["user_id"])): ?>
                localStorage.setItem('selectedCheckoutItems', JSON.stringify(selectedItems));
                window.location.href = "checkout.php";
            <?php else: ?>
                alert("Please login to continue!");
                window.location.href = "login.php";
            <?php endif; ?>
        });

        window.onload = loadCart;
    </script>


</body>

</html>