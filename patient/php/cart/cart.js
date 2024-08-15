$(document).ready(function() {
    function filterProducts(searchTerm) {
        let products = $(".listProduct");
        products.each(function() {
            let productName = $(this).data("product-name").toLowerCase();
            if (productName.includes(searchTerm.toLowerCase())) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $("#searchButton").click(function() {
        let searchTerm = $("#searchInput").val();
        filterProducts(searchTerm);
    });

    $("#searchInput").on("input", function() {
        let searchTerm = $(this).val();
        filterProducts(searchTerm);
    });

    function addToCart(medid, medname, medprice, medimage) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        let existingCartItem = cart.find(item => item.medid === medid);
        if (existingCartItem) {
            existingCartItem.quantity++;
        } else {
            cart.push({
                medid: medid,
                medname: medname,
                medprice: medprice,
                medimage: medimage,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        updateTotalQuantity();
        updateTotalCost();
        addSparkleEffect();
    }

    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartItems = $(".cart-items");
        cartItems.empty(); // Clear the existing cart items
    
        if (cart.length === 0) {
            cartItems.append('<p class="empty-cart">No item in the cart</p>');
        } else {
            let cartItemsHtml = cart.map(item => `
                <div class="cart-item" data-product-id="${item.medid}">
                    <img class="cart-image" src="${item.medimage}" alt="${item.medname}">
                    <div>
                        <p class="cart-name">${item.medname}</p>
                        <p class="cart-price">₹${item.medprice.toFixed(2)}</p>
                    </div>
                    <div class="cart-quantity">
                        <button class="quantity-btn minus" data-product-id="${item.medid}">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn plus" data-product-id="${item.medid}">+</button>
                    </div>
                </div>
            `).join('');
    
            cartItems.html(cartItemsHtml);
        }
    }

    function updateTotalQuantity() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
        $(".totalQuantity").text(totalQuantity);
    }

    function updateTotalCost() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalCost = cart.reduce((sum, item) => sum + (item.medprice * item.quantity), 0);
        $(".totalCost").text("Total: ₹" + totalCost.toFixed(2));
    }

    function addSparkleEffect() {
        const cartIcon = document.getElementById('cartIcon');
        const sparkleContainer = document.createElement('div');
        sparkleContainer.className = 'sparkle-effect';
        
        const sparkles = ['sparkle1', 'sparkle2', 'sparkle3'];
        sparkles.forEach(sparkleClass => {
            const sparkle = document.createElement('div');
            sparkle.className = sparkleClass;
            sparkleContainer.appendChild(sparkle);
        });
        
        cartIcon.parentNode.appendChild(sparkleContainer);

        setTimeout(() => {
            sparkleContainer.remove();
        }, 1000); 
    }
    function handleCheckout() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            $('.checkout-message').remove(); // Remove any existing message
            $('.cart-container').append('<p class="checkout-message">Please add items in order to checkout</p>');
        } else {
            // Proceed with the checkout process
            // ...
        }
    }

    $(document).on('click', '.add', function() {
        let parent = $(this).closest('.listProduct');
        let medid = parent.data('product-id');
        let medname = parent.data('product-name');
        let medprice = parseFloat(parent.data('product-price'));
        let medimage = parent.data('product-image');

        addToCart(medid, medname, medprice, medimage);
    });

    $(document).on('click', '.quantity-btn.plus', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let parent = $(this).closest('.cart-item');
        let medid = parent.data('product-id');
        let item = cart.find(item => item.medid === medid);
        if (item) {
            item.quantity++;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateTotalQuantity();
            updateTotalCost();
        }
    });

    $(document).on('click', '.quantity-btn.minus', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let parent = $(this).closest('.cart-item');
        let medid = parent.data('product-id');
        let item = cart.find(item => item.medid === medid);
        if (item) {
            if (item.quantity > 1) {
                item.quantity--;
            } else {
                cart = cart.filter(item => item.medid !== medid);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateTotalQuantity();
            updateTotalCost();
        }
    });

    $('#closeCart').click(function() {
        $('.cart-container').removeClass('show');
    });

    $('.iconcart').click(function() {
        $('.cart-container').toggleClass('show');
    });

    $(document).on('click', '#checkout-cart', function() {
        handleCheckout();
    });

    renderCart();
    updateTotalQuantity();
    updateTotalCost();
});
