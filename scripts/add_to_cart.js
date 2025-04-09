document.addEventListener('click', function (e) {
    // ======= HANDLE cart-btn AND buy-btn (open zoom modal) =======
    if (e.target.classList.contains('cart-btn') || e.target.classList.contains('buy-btn')) {
        const isBuyNow = e.target.classList.contains('buy-btn');
        const card = e.target.closest('.shoe-card');
        const shoeId = card.dataset.id;
        const shoeName = card.querySelector('h2')?.textContent || 'Unnamed';
        const imageUrl = card.querySelector('img')?.src || '';
        const priceText = card.querySelector('.price')?.textContent || '0₫';

        // Parse size-stock list
        const sizes = JSON.parse(card.dataset.sizes || '[]');

        const clone = card.cloneNode(true);
        clone.classList.add('zoom-modal');
        clone.querySelectorAll('.cart-btn, .buy-btn').forEach(btn => btn.remove());
        document.body.appendChild(clone);

        const popup = document.createElement('div');
        popup.classList.add('option-popup');

        // Tạo dropdown size và stock động
        let sizeOptions = '';
        sizes.forEach(s => {
            sizeOptions += `<option value="${s.size}">${s.size}</option>`;
        });

        popup.innerHTML = `
            <h2>${shoeName}</h2>
            <p class="stock-info">In stock: <strong class="stock-value">${sizes[0]?.stock || 0}</strong></p>
            <label>Size</label>
            <select class="size-select">
                ${sizeOptions}
            </select>
            <div class="popup-buttons">
                <button class="${isBuyNow ? 'buy-now-btn' : 'confirm-btn'}" 
                        data-id="${shoeId}" 
                        data-name="${shoeName}"
                        data-img="${imageUrl}">
                    ${isBuyNow ? 'Buy' : 'Confirm'}
                </button>  
                <button class="cancel-btn">Cancel</button>
            </div>
        `;
        clone.appendChild(popup);

        // Gắn sự kiện khi chọn size thì hiện đúng stock
        const sizeSelect = popup.querySelector('.size-select');
        const stockValue = popup.querySelector('.stock-value');
        sizeSelect.addEventListener('change', function () {
            const selectedSize = this.value;
            const selected = sizes.find(s => s.size == selectedSize);
            stockValue.textContent = selected ? selected.stock : '0';
        });
    }

    // ======= Cancel the zoom modal =======
    if (e.target.classList.contains('cancel-btn')) {
        document.querySelector('.zoom-modal')?.remove();
    }

    // ======= Add to cart =======
    if (e.target.classList.contains('confirm-btn')) {
        const modal = document.querySelector('.zoom-modal');
        const size = modal.querySelector('.size-select').value;
        const shoeId = e.target.dataset.id;
        const shoeName = e.target.dataset.name;
        const imageUrl = e.target.dataset.img;
        const priceText = modal.querySelector('.price')?.textContent || '0₫';
        const price = parseInt(priceText.replace(/[^\d]/g, ''), 10);

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let found = cart.find(item => item.id === shoeId && item.size === size);

        if (found) {
            found.quantity += 1;
        } else {
            cart.push({
                id: shoeId,
                name: shoeName,
                image: imageUrl,
                size: size,
                price: price,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`Added to cart:\nName: ${shoeName}\nSize: ${size}\nPrice: ${priceText}`);
        modal.remove();
    }

    // ======= Buy Now (go to checkout) =======
    if (e.target.classList.contains('buy-now-btn')) {
        const modal = document.querySelector('.zoom-modal');
        const size = modal.querySelector('.size-select').value;
        const shoeId = e.target.dataset.id;
        const shoeName = e.target.dataset.name;
        const imageUrl = e.target.dataset.img;
        const priceText = modal.querySelector('.price')?.textContent || '0₫';
        const price = parseInt(priceText.replace(/[^\d]/g, ''), 10);

        const checkoutItem = {
            id: shoeId,
            name: shoeName,
            image: imageUrl,
            size: size,
            price: price,
            quantity: 1
        };

        localStorage.setItem('checkout-items', JSON.stringify([checkoutItem]));
        window.location.href = 'checkout.php';
    }
});
