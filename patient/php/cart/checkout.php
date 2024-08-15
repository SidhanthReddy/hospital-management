<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['pid'])) {
$patientName = htmlspecialchars($_SESSION['pid']);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="checkout.css"> <!-- Link to your checkout page CSS file -->
    <script src="checkout.js"></script>
</head> 
<body>
    <h1>Purchase Medications</h1>
    <div class="main-container">
        <div class="cart-summary">
            <h2>Prescription-list</h2>
            <div id="cart-items"></div>
            <div id="total-cost" class="total-cost"></div>
        </div>
        <div class="checkout-container">
            <form method="POST" action="confirm_prescription.php" onsubmit="return validateCart()">
                <input type="hidden" name="cart_items" id="cart_items">
                <input type="hidden" name="patient_name" value="<?php echo $patientName; ?>">
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="Enter your location" required>
                </div>
                <div class="form-group">
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="" selected disabled>Select state</option>
                        <option value="state1">State 1</option>
                        <option value="state2">State 2</option>
                        <option value="state3">State 3</option>
                        <!-- Add more options for other states as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment-method">Payment Method:</label>
                    <select id="payment-method" name="payment-method" required>
                        <option value="" selected disabled>Select payment method</option>
                        <option value="cash">Cash</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <div class="form-group">
                    <img src="qrcode.jpg" alt="PhonePe QR Code" id="phonepe-qr" class="phonepe-qr" style="display: none;">
                </div>
                <button type="submit" name="confirm" value="yes" class="yes">Confirm Purchase</button>
            </form>
        </div>
    </div>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log('Cart:', cart); // Log the cart to verify its structure

    document.getElementById('cart_items').value = JSON.stringify(cart);

    if (cart.length === 0) {
        alert('Cart is empty. Please add items to the cart before confirming the prescription.');
        window.location.href = 'cart.php?patient_name=<?php echo $patientName; ?>'; // Redirect to cart.php with patient_name
    } else {
        // Optionally, calculate and display total cost if your cart items have a price property
        let totalCost = cart.reduce((total, item) => {
            let itemPrice = item.medprice || 0;
            let itemQuantity = item.quantity || 1;
            return total + (itemPrice * itemQuantity);
        }, 0);
        document.getElementById('total-cost').textContent = `Total Cost: ₹${totalCost.toFixed(2)}`;
    }

    const paymentMethodSelect = document.getElementById('payment-method');
    const qrCodeImg = document.getElementById('phonepe-qr');

    paymentMethodSelect.addEventListener('change', function() {
        if (paymentMethodSelect.value === 'online') {
            qrCodeImg.style.display = 'block';
        } else {
            qrCodeImg.style.display = 'none';
        }
    });
});

function validateCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert('Cart is empty. Please add items to the cart before confirming the prescription.');
        window.location.href = 'cart.php?patient_name=<?php echo $patientName; ?>'; // Redirect to cart.php with patient_name
        return false;
    }
    return true;
}
</script>

</body>
</html>

 