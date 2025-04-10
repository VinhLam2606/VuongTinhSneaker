<?php
session_start();
include 'connect-db.php';

// Kiểm tra xem phương thức HTTP có phải là POST không
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['account_id'])) {
        echo "Unauthorized: Please log in to place an order.";
        exit;
    }

    $account_id = $_SESSION['account_id'];
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra xem dữ liệu yêu cầu có hợp lệ không
    if (!isset($data['items']) || !isset($data['total'])) {
        echo "Invalid request: missing order data.";
        exit;
    }

    $items = $data['items'];
    $total = $data['total'];

    // Insert vào bảng order_history
    $insertOrder = $db_server->prepare("INSERT INTO order_history (account_id, oh_total, order_date) VALUES (?, ?, NOW())");
    if (!$insertOrder) {
        die("Failed to prepare order insertion: " . $db_server->error);
    }
    $insertOrder->bind_param("ii", $account_id, $total);
    if (!$insertOrder->execute()) {
        die("Order insertion failed: " . $insertOrder->error);
    }

    $order_id = $insertOrder->insert_id;

    // Insert mỗi chi tiết vào bảng order_detail và xóa hàng trong bảng shoe
    $insertDetail = $db_server->prepare("INSERT INTO order_detail (oh_id, st_id, od_quantity, od_size) VALUES (?, ?, ?, ?)");
    if (!$insertDetail) {
        die("Failed to prepare order detail insertion: " . $db_server->error);
    }
    
    $deleteShoe = $db_server->prepare("DELETE FROM shoe WHERE st_id = ? AND shoe_size = ? LIMIT 1");
    if (!$deleteShoe) {
        die("Failed to prepare shoe deletion: " . $db_server->error);
    }

    foreach ($items as $item) {
        $st_id = $item['st_id'];
        $shoe_size = $item['shoe_size'];
        $quantity = $item['quantity'] ?? 1;

        // Insert vào bảng order_detail
        $insertDetail->bind_param("iiii", $order_id, $st_id, $quantity, $shoe_size);
        if (!$insertDetail->execute()) {
            die("Insert detail failed: " . $insertDetail->error);
        }

        // Xóa từng đôi giày theo số lượng
        for ($i = 0; $i < $quantity; $i++) {
            $deleteShoe->bind_param("ii", $st_id, $shoe_size);
            if (!$deleteShoe->execute()) {
                echo "Failed to delete shoe with st_id $st_id and shoe_size $shoe_size.";
                exit;
            }
            if ($deleteShoe->affected_rows === 0) {
                echo "Out of stock for st_id $st_id, size $shoe_size.";
                exit;
            }
        }
    }

    echo "success";
    exit;
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
            <p><strong id="total"></strong></p>
        </div>
    </div>

    <script src="../scripts/checkout.js"></script>
</body>

</html>
