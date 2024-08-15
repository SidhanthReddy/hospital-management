document.addEventListener("DOMContentLoaded", function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let cartItemsContainer = document.getElementById('cart-items');
    cart.forEach(item => {
        let cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.innerHTML = `
            <img class="cart-image" src="${item.medimage}" alt="${item.medname}">
            <div>
                <p class="cart-name">${item.medname}</p>
                <p class="cart-price">₹${item.medprice}</p>
                <p class="cart-quantity">Quantity: ${item.quantity}</p>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);
    });

    let totalCost = cart.reduce((sum, item) => sum + (item.medprice * item.quantity), 0);
    document.getElementById('total-cost').textContent = "Total: ₹" + totalCost.toFixed(2);
}); 