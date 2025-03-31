document.addEventListener('click', function (e) {
    if (e.target.classList.contains('cart-btn')) {
        const card = e.target.closest('.shoe-card');
        const stock = card.dataset.stock || 'Unknown';
        const shoeId = card.dataset.id;
        const shoeName = card.querySelector('h2')?.textContent || 'Unnamed';
        const imageUrl = card.querySelector('img')?.src || '';

        const clone = card.cloneNode(true);
        clone.classList.add('zoom-modal');
        clone.querySelectorAll('.cart-btn, .buy-btn').forEach(btn => btn.remove());
        document.body.appendChild(clone);

        const popup = document.createElement('div');
        popup.classList.add('option-popup');
        popup.innerHTML = `
            <h2>${shoeName}</h2>
            <p class="stock-info">In stock: <strong>${stock}</strong></p>
            <label>Size</label>
            <select class="size-select">
                <option>36</option><option>37</option><option>38</option>
                <option>39</option><option>40</option><option>41</option>
                <option>42</option><option>43</option><option>44</option><option>45</option>
            </select>
            <div class="popup-buttons">
                <button class="confirm-btn" 
                        data-id="${shoeId}" 
                        data-name="${shoeName}"
                        data-img="${imageUrl}">
                    Confirm
                </button>  
                <button class="cancel-btn">Cancel</button>
            </div>
        `;
        clone.appendChild(popup);
    }

    if (e.target.classList.contains('cancel-btn')) {
        document.querySelector('.zoom-modal')?.remove();
    }

    if (e.target.classList.contains('confirm-btn')) {
        const modal = document.querySelector('.zoom-modal');
        const size = modal.querySelector('.size-select').value;
        const shoeId = e.target.dataset.id;
        const shoeName = e.target.dataset.name;
        const imageUrl = e.target.dataset.img;

        // 🔥 Tìm thẻ chứa giá tiền
        const priceText = modal.querySelector('.price')?.textContent || '0₫';
        const price = parseInt(priceText.replace(/[^\d]/g, ''), 10); // Chỉ giữ lại số

        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if item already exists with same id + size
        let found = cart.find(item => item.id === shoeId && item.size === size);

        if (found) {
            found.quantity += 1;
        } else {
            cart.push({
                id: shoeId,
                name: shoeName,
                image: imageUrl,
                size: size,
                price: price,  // 🔥 Thêm giá vào đây
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`Added to cart:\nName: ${shoeName}\nSize: ${size}\nPrice: ${priceText}`);
        modal.remove();
    }

});
