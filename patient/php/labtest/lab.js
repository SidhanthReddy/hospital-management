document.addEventListener("DOMContentLoaded", function() {
    const cartIcon = document.querySelector(".iconcart");
    const cartBox = document.querySelector(".cart-container");
    const closeCartButton = document.querySelector(".close-cart");
    const cartItemsContainer = document.querySelector(".cart-items");
    const totalQuantity = document.querySelector(".totalQuantity");
    const totalCostElement = document.querySelector(".totalCost");
    const searchInput = document.querySelector("#search");
    const itemsContainer = document.querySelector("#itemsContainer");

    // Clear cartItems from localStorage when the page loads
    localStorage.removeItem("cartItems");
    let cartItems = [];

    function updateCartDisplay() {
        cartItemsContainer.innerHTML = "";
        let totalCost = 0;

        cartItems.forEach(item => {
            const itemElement = document.createElement("div");
            itemElement.classList.add("cart-item");

            const productImage = document.createElement("div");
            productImage.classList.add("cart-product-image");
            productImage.innerHTML = `<img src="data:image/png;base64,${item.labimage}" alt="${item.name} image" />`;

            const productDetails = document.createElement("div");
            productDetails.classList.add("cart-product-details");
            productDetails.innerHTML = `
                <div class="cart-name">${item.name}</div>
                <div class="cart-price">₹${item.price.toFixed(2)}</div>
            `;

            const removeButton = document.createElement("button");
            removeButton.textContent = "Remove";
            removeButton.classList.add("cart-remove");
            removeButton.setAttribute("data-id", item.id);
            removeButton.addEventListener("click", function() {
                removeFromCart(item.id);
            });

            itemElement.appendChild(productImage);
            itemElement.appendChild(productDetails);
            itemElement.appendChild(removeButton);

            cartItemsContainer.appendChild(itemElement);

            totalCost += item.price;
        });

        totalQuantity.textContent = cartItems.length;
        totalCostElement.textContent = `Total Cost: ₹${totalCost.toFixed(2)}`;

        // Save cart items to localStorage
        localStorage.setItem("cartItems", JSON.stringify(cartItems));
        console.log("Cart Items Updated:", cartItems);
    }

    function toggleButtonState(productId, action) {
        const buttons = document.querySelectorAll(`button[data-id="${productId}"]`);
        buttons.forEach(button => {
            if (action === "add") {
                button.textContent = "Add";
                button.classList.remove("remove");
                button.classList.add("add");
            } else {
                button.textContent = "Remove";
                button.classList.remove("add");
                button.classList.add("remove");
            }
        });
    }

    function applySparkleEffect() {
        cartIcon.classList.add("sparkle-effect");
        const sparkle1 = document.createElement("span");
        const sparkle2 = document.createElement("span");
        const sparkle3 = document.createElement("span");
        sparkle1.className = "sparkle1";
        sparkle2.className = "sparkle2";
        sparkle3.className = "sparkle3";
        cartIcon.appendChild(sparkle1);
        cartIcon.appendChild(sparkle2);
        cartIcon.appendChild(sparkle3);
        setTimeout(() => {
            cartIcon.classList.remove("sparkle-effect");
            sparkle1.remove();
            sparkle2.remove();
            sparkle3.remove();
        }, 1000); // Duration of the animation
    }

    function removeFromCart(itemId) {
        cartItems = cartItems.filter(item => item.id !== itemId);
        toggleButtonState(itemId, "add");
        updateCartDisplay();
    }

    cartIcon.addEventListener("click", function() {
        cartBox.classList.toggle("show");
    });

    closeCartButton.addEventListener("click", function() {
        cartBox.classList.remove("show");
    });

    document.body.addEventListener("click", function(event) {
        if (event.target.classList.contains("add")) {
            const productElement = event.target.closest(".listProduct");
            const id = productElement.getAttribute("data-product-id");
            const name = productElement.querySelector(".name").textContent;
            const price = parseFloat(productElement.querySelector(".price").textContent);
            const labimage = productElement.querySelector(".image").src.split(",")[1]; // Get base64 image data

            cartItems.push({ id, name, price, labimage });

            toggleButtonState(id, "remove");
            updateCartDisplay();
            applySparkleEffect(); // Apply sparkle effect when an item is added to the cart
        } else if (event.target.classList.contains("remove")) {
            const itemId = event.target.getAttribute("data-id");

            cartItems = cartItems.filter(item => item.id !== itemId);

            toggleButtonState(itemId, "add");
            updateCartDisplay();
        }
    });

    // Search Functionality
    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.toLowerCase();
        const items = itemsContainer.querySelectorAll(".listProduct");

        items.forEach(item => {
            const name = item.querySelector(".name").textContent.toLowerCase();
            if (name.includes(searchTerm)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Initial display update
    updateCartDisplay();
});
