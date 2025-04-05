document.addEventListener("DOMContentLoaded", function () {
    const addProductButton = document.querySelector('.add-product');

    if (addProductButton) {
        addProductButton.addEventListener("click", function () {
            window.location.href = 'add_product.php'; // Redirect to add_product.php
        });
    }
});