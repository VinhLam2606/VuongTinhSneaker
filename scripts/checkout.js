document.addEventListener("DOMContentLoaded", function () {
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

function submitPayment() {
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

    if (paymentMethod === "credit-card") {
        const valid = validateCreditCardFields();
        if (!valid) {
            alert("Please fill in all required credit card fields.");
            return;
        }
    }

    // Lấy dữ liệu từ localStorage
    const selectedItems = JSON.parse(localStorage.getItem("checkout-items")) || [];

    // Lấy tổng tiền từ DOM
    const total = parseInt(document.getElementById("total").textContent.replace(/\D/g, '')) || 0;

    // Gửi dữ liệu về PHP bằng fetch
    fetch("checkout.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            items: selectedItems.map(item => ({
                st_id: item.id,
                shoe_size: item.size,
                quantity: item.quantity,
                price: item.price
            })),
            total: total
        })
    })
    .then(response => response.text())
    .then(result => {
        alert("Payment submitted!");
        console.log(result); // Log the response from the server

        // Xoá các sản phẩm đã thanh toán khỏi giỏ hàng
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        selectedItems.forEach(item => {
            cart = cart.filter(cartItem => cartItem.id !== item.id);
        });
        localStorage.setItem("cart", JSON.stringify(cart));
        localStorage.setItem("checkout-items", JSON.stringify([])); // Clear checkout items
        window.location.href = "cart.php";
    });
}

