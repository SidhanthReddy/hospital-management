document.addEventListener("DOMContentLoaded", function() {
    const cartSummary = document.getElementById("cart-summary");
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    let totalPrice = 0;
    const payButton = document.getElementById("pay-button");

    if (cartItems.length === 0) {
        cartSummary.innerHTML = "<p>Your cart is empty</p>";
        payButton.disabled = true; // Disable the pay button
    } else {
        let summaryHTML = "<h2>Your Cart</h2><div class='product-boxes'>";
        cartItems.forEach(item => {
            totalPrice += item.price;
            summaryHTML += `
                <div class="product-box">
                    <img src="data:image/png;base64,${item.labimage}" alt="${item.name} image" width="50" />
                    <span>${item.name} - ₹${item.price.toFixed(2)}</span>
                </div>
            `;
        });

        summaryHTML += "</div>";
        cartSummary.innerHTML = summaryHTML;
        payButton.textContent = `Pay ₹${totalPrice.toFixed(2)}`;

    }

    // Add event listener to the form
    const checkoutForm = document.getElementById("checkout-form");
    checkoutForm.addEventListener("submit", function(event) {
        event.preventDefault();

        if (cartItems.length === 0) {
            alert("No items in the cart. Please add items to proceed.");
            return;
        }

        const formData = {
            id: generateUniqueId(), // Generate a unique ID for the transaction
            name: document.getElementById("name").value,
            location: document.getElementById("location").value,
            phone: document.getElementById("phone").value,
            email: document.getElementById("email").value,
            state: document.getElementById("state").value
        };

        // Form validation
        if (!validateForm(formData)) {
            alert("Please fill in all the required fields correctly.");
            return;
        }

        // Show confirmation modal
        if (!confirm("Are you sure you want to proceed to payment?")) {
            return;
    
        }
    });

    function validateForm(data) {
        const phonePattern = /^\d{10}$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!data.name || !data.location || !data.phone || !data.email || !data.state) {
            return false;
        }
        if (!phonePattern.test(data.phone)) {
            alert("Please enter a valid phone number.");
            return false;
        }
        if (!emailPattern.test(data.email)) {
            alert("Please enter a valid email address.");
            return false;
        }
        window.location.href = 'lab.php'; 
        return true;
    }
    function generateUniqueId() {
        return 'id-' + Math.random().toString(36).substr(2, 16);
    }
    document.getElementById('pay-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Optionally, you can add validation before redirecting
        alert("Payment confirmed");
        // Redirect to lab.php
        window.location.href = 'lab.php';
    });

});
