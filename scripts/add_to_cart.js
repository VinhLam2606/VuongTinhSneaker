document.addEventListener('click', function (e) {
    if (e.target.classList.contains('cart-btn')) {
        const card = e.target.closest('.shoe-card');
        const clone = card.cloneNode(true);
        clone.classList.add('zoom-modal');
        document.body.appendChild(clone);

        // Remove existing popup inside clone if any
        const existingPopup = clone.querySelector('.option-popup');
        if (existingPopup) existingPopup.remove();

        // Add popup inside modal
        const popup = document.createElement('div');
        popup.classList.add('option-popup');
        popup.innerHTML = `
            <h2>${card.querySelector('h2').textContent}</h2>
            <label>Size</label>
            <select class="size-select">
                <option>36</option>
                <option>37</option>
                <option>38</option>
                <option>39</option>
                <option>40</option>
                <option>41</option>
                <option>42</option>
                <option>43</option>
                <option>44</option>
                <option>45</option>
            </select>
            <label>Color</label>
            <select class="color-select">
                <option>Black</option><option>White</option>
                <option>Red</option><option>Blue</option>
            </select>
            <div class="popup-buttons">
                <button class="confirm-btn">Confirm</button>
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
        const color = modal.querySelector('.color-select').value;
        alert(`Added to cart:\nSize: ${size}\nColor: ${color}`);
        modal.remove();
    }
});
