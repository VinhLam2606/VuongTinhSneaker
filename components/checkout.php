<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/checkout.css" />
    <title>Checkout Form</title>
</head>

<body>
    <div class="container">
        <div class="checkout-form">
            <div class="progress-steps">
                <div class="step active"><span class="icon">👤</span></div>
                <div class="line"></div>
                <div class="step"><span class="icon">🚚</span></div>
                <div class="line"></div>
                <div class="step"><span class="icon">💳</span></div>
            </div>

            <div class="form-step" id="step-information">
                <h2>Customer Information</h2>
                <div class="input-group"><label>First Name</label><input type="text" id="firstName"></div>
                <div class="input-group"><label>Last Name</label><input type="text" id="lastName"></div>
                <div class="input-group"><label>Email Address</label><input type="email" id="email"></div>
                <div class="input-group"><label>Phone Number</label><input type="tel" id="phone"></div>
                <button class="next-btn" onclick="nextStep('shipping')">Continue to Shipping</button>
            </div>

            <div class="form-step hidden" id="step-shipping">
                <h2>Shipping Address</h2>
                <div class="input-group"><label>Street Address</label><input type="text" id="address"></div>
                <div class="input-group"><label>City</label><input type="text" id="city"></div>
                <div class="form-nav">
                    <button class="back-btn" onclick="prevStep('information')">Back</button>
                    <button class="next-btn" onclick="nextStep('payment')">Continue to Payment</button>
                </div>
            </div>

            <div class="form-step hidden" id="step-payment">
                <h2>Payment Method</h2>
                <div class="payment-option"><input type="radio" id="credit-card" name="paymentMethod" checked><label for="credit-card">Credit Card</label></div>
                <div class="input-group"><label>Card Number</label><input type="text" id="cardNumber" placeholder="1234 5678 9012 3456"></div>
                <div class="input-group"><label>Expiration Date</label><input type="text" id="expDate" placeholder="MM / YY"></div>
                <div class="input-group"><label>CVV</label><input type="text" id="cvv" placeholder="123"></div>
                <div class="payment-option"><input type="radio" id="paypal" name="paymentMethod"><label for="paypal">PayPal</label></div>
                <div class="payment-option"><input type="radio" id="applepay" name="paymentMethod"><label for="applepay">Apple Pay</label></div>
                <div class="form-nav">
                    <button class="back-btn" onclick="prevStep('shipping')">Back</button>
                    <button class="next-btn">Submit Payment</button>
                </div>
            </div>
        </div>

        <div class="summary-section">
            <h3>Order Items</h3>
            <div id="order-items"></div>
            <hr>
            <h3>Order Summary</h3>
            <p id="subtotal"></p>
            <p id="shipping"></p>
            <p id="tax"></p>
            <p><strong id="total"></strong></p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let orderItemsContainer = document.getElementById("order-items");
            let subtotal = 0;
            
            cart.forEach(item => {
                let itemElement = document.createElement("div");
                itemElement.classList.add("order-item");
                itemElement.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="item-image" width="50">
                    <p>${item.name} - Size: ${item.size} | Quantity: ${item.quantity}</p>
                    <p>Price: ${item.price.toLocaleString()}₫</p>
                `;
                orderItemsContainer.appendChild(itemElement);
                subtotal += item.price * item.quantity;
            });
            
            let shipping = 30000;
            let total = subtotal + shipping;

            document.getElementById("subtotal").textContent = `Subtotal: ${subtotal.toLocaleString()}₫`;
            document.getElementById("shipping").textContent = `Shipping: ${shipping.toLocaleString()}₫`;
            document.getElementById("total").textContent = `Total: ${total.toLocaleString()}₫`;
        });

        function nextStep(step) {
            document.querySelectorAll(".form-step").forEach(el => el.classList.add("hidden"));
            document.getElementById(`step-${step}`).classList.remove("hidden");
        }

        function prevStep(step) {
            document.querySelectorAll(".form-step").forEach(el => el.classList.add("hidden"));
            document.getElementById(`step-${step}`).classList.remove("hidden");
        }
    </script>
</body>

</html>
