<?php
include 'connect-db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data)) {
        $deleteQuery = "DELETE FROM shoe WHERE st_id = ? AND shoe_size = ? LIMIT 1";
        $stmt = $db_server->prepare($deleteQuery);

        foreach ($data as $item) {
            $st_id = $item['st_id'];
            $shoe_size = $item['shoe_size'];
            $quantity = $item['quantity'] ?? 1; // fallback nếu không có quantity

            // Lặp đúng số lượng để xoá từng dòng một
            for ($i = 0; $i < $quantity; $i++) {
                $stmt->bind_param("ii", $st_id, $shoe_size);
                $stmt->execute();
            }
            
        }

        exit; // Dừng tại đây sau khi xử lý POST
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/checkout.css" />
    <title>Vuong Tinh Sneaker</title>
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

            <div class="form-step active" id="step-information">
                <h2>Customer Information</h2>
                <div class="input-group"><label>Full Name</label><input type="text" id="firstName" required></div>
                <div class="input-group">
                    <label>Gender</label>
                    <select id="gender" required>
                        <option value="" hidden>Please choose a gender</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                    </select>
                </div>
                <div class="input-group"><label>Phone Number</label><input type="tel" id="phone" required></div>
                <div class="form-nav">
                    <button class="back-btn" onclick="window.location.href='cart.php'">Back</button>
                    <button class="next-btn" onclick="nextStep('shipping')">Continue to Shipping</button>
                </div>
            </div>

            <div class="form-step hidden" id="step-shipping">
                <h2>Shipping Address</h2>
                <div class="input-group"><label>Address</label><input type="text" id="address" required></div>
                <div class="input-group"><label>City</label><input type="text" id="city" required></div>
                <div class="input-group">
                    <label>Shipping Method</label>
                    <select id="shippingMethod" onchange="updateShippingCost()" required>
                        <option value="" hidden selected>Please choose a shipping method</option>
                        <option value="fast">Fast</option>
                        <option value="normal">Normal</option>
                        <option value="slow">Slow</option>
                    </select>
                </div>
                <div class="form-nav">
                    <button class="back-btn" onclick="prevStep('information')">Back</button>
                    <button class="next-btn" onclick="nextStep('payment')">Continue to Payment</button>
                </div>
            </div>

            <div class="form-step hidden" id="step-payment">
                <h2>Payment Method</h2>
                <div class="payment-option">
                    <input type="radio" id="cash" name="paymentMethod" value="cash" checked onclick="toggleCreditCardFields()">
                    <label for="cash">Cash</label>
                </div>
                <div class="payment-option">
                    <input type="radio" id="credit-card" name="paymentMethod" value="credit-card" onclick="toggleCreditCardFields()">
                    <label for="credit-card">Credit Card</label>
                </div>
                <div id="credit-card-fields" class="hidden">
                    <div class="input-group"><label>Card Number</label><input type="text" id="cardNumber" placeholder="1234 5678 9012 3456"></div>
                    <div class="input-group"><label>Expiration Date</label><input type="text" id="expDate" placeholder="MM / YY"></div>
                    <div class="input-group"><label>CVV</label><input type="text" id="cvv" placeholder="123"></div>
                </div>
                <div class="form-nav">
                    <button class="back-btn" onclick="prevStep('shipping')">Back</button>
                    <button class="next-btn" onclick="submitPayment()">Submit Payment</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            let selectedItems = JSON.parse(localStorage.getItem("checkout-items")) || [];
            let orderItemsContainer = document.getElementById("order-items");
            let subtotal = 0;

            if (selectedItems.length === 0) {
                orderItemsContainer.innerHTML = "<p>No items selected for checkout.</p>";
                return; // Exit if no selected items
            }

            selectedItems.forEach(item => {
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

            document.getElementById("subtotal").textContent = `Subtotal: ${subtotal.toLocaleString()}₫`;
            updateShippingCost();
        });

        function updateShippingCost() {
            const shippingMethod = document.getElementById("shippingMethod").value;
            let shipping = 0;
            let days = 0;

            switch (shippingMethod) {
                case "fast":
                    shipping = 50000;
                    days = 2;
                    break;
                case "normal":
                    shipping = 30000;
                    days = 4;
                    break;
                case "slow":
                    shipping = 10000;
                    days = 7;
                    break;
                default:
                    shipping = 0;
                    days = 0;
                    break;
            }

            let subtotal = parseInt(document.getElementById("subtotal").textContent.replace(/\D/g, '')) || 0;
            let total = subtotal + shipping;

            document.getElementById("shipping").textContent = `Shipping: ${shipping.toLocaleString()}₫ (${days} days)`;
            document.getElementById("total").textContent = `Total: ${total.toLocaleString()}₫`;
        }

        function toggleCreditCardFields() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            const creditCardFields = document.getElementById("credit-card-fields");
            if (paymentMethod === "credit-card") {
                creditCardFields.classList.remove("hidden");
                creditCardFields.querySelectorAll("input").forEach(input => input.required = true);
            } else {
                creditCardFields.classList.add("hidden");
                creditCardFields.querySelectorAll("input").forEach(input => input.required = false);
            }
        }

        function validateStepInformation() {
            const firstName = document.getElementById("firstName").value;
            const gender = document.getElementById("gender").value;
            const phone = document.getElementById("phone").value;

            return firstName !== "" && gender !== "" && phone !== "";
        }

        function validateStepShipping() {
            const address = document.getElementById("address").value;
            const city = document.getElementById("city").value;
            const shippingMethod = document.getElementById("shippingMethod").value;

            return address !== "" && city !== "" && shippingMethod !== "";
        }

        function validateCreditCardFields() {
            const cardNumber = document.getElementById("cardNumber").value;
            const expDate = document.getElementById("expDate").value;
            const cvv = document.getElementById("cvv").value;

            return cardNumber !== "" && expDate !== "" && cvv !== "";
        }

        function nextStep(step) {
            let valid = false;

            if (step === 'shipping') {
                valid = validateStepInformation();
            } else if (step === 'payment') {
                valid = validateStepShipping();
            }

            if (valid) {
                document.querySelectorAll(".form-step").forEach(el => el.classList.add("hidden"));
                document.getElementById(`step-${step}`).classList.remove("hidden");
            } else {
                alert("Please fill in all required fields.");
            }
        }

        function prevStep(step) {
            document.querySelectorAll(".form-step").forEach(el => el.classList.add("hidden"));
            document.getElementById(`step-${step}`).classList.remove("hidden");
        }

        function submitPayment() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            if (paymentMethod === "credit-card") {
                const valid = validateCreditCardFields();
                if (!valid) {
                    alert("Please fill in all required credit card fields.");
                    return;
                }
            }

            // Lấy dữ liệu cần gửi
            const selectedItems = JSON.parse(localStorage.getItem("checkout-items")) || [];

            // Gửi dữ liệu về PHP bằng fetch
            fetch("checkout.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(selectedItems.map(item => ({
                        st_id: item.id,
                        shoe_size: item.size,
                        quantity: item.quantity
                    })))

                })
                .then(response => response.text())
                .then(result => {
                    alert("Payment submitted!");
                    console.log(result); // Xem dữ liệu được server phản hồi

                    // Cập nhật lại cart như cũ
                    let cart = JSON.parse(localStorage.getItem("cart")) || [];
                    selectedItems.forEach(item => {
                        cart = cart.filter(cartItem => cartItem.id !== item.id);
                    });
                    localStorage.setItem("cart", JSON.stringify(cart));
                    localStorage.setItem("checkout-items", JSON.stringify([]));
                    window.location.href = "cart.php";
                });
        }
    </script>
</body>

</html>