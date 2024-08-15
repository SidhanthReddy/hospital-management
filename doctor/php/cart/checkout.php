<!DOCTYPE html>
<?php
session_start();
include 'connection.php';

$patientName = $_GET['patient_name'];

// Prepare the SQL statement
$query = "SELECT pid FROM login11 WHERE fname = ?";
$stmt = $connect->prepare($query);

if ($stmt) {
    // Bind the parameters and execute the statement
    $stmt->bind_param("s", $patientName);
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($patientId);

    // Fetch the result
    if ($stmt->fetch()) {
        // If patient is found, do something with $patientId
    } else {
        $patientId = "not found";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the statement: " . $connect->error;
}

// Close the connection
$connect->close();
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
<h1>Add Prescription for Patient ID:<?php echo htmlspecialchars($patientId); ?></h1>
    <div class="main-container">
        <div class="cart-summary">
            <h2>Prescription-list</h2>
            <div id="cart-items"></div>
            <div id="total-cost" class="total-cost"></div>
        </div>
        <div class="checkout-container">
            <p>Would you like to confirm the patient's prescription?</p>
            <form method="POST" action="confirm_prescription.php" onsubmit="return validateCart()">
                <input type="hidden" name="cart_items" id="cart_items">
                <input type="hidden" name="patient_name" value="<?php echo htmlspecialchars($patientName); ?>">
                <button type="submit" name="confirm" value="yes" class="yes">YES</button>
                <button type="submit" name="confirm" value="no" class="no">NO</button>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        console.log('Cart:', cart); // Log the cart to verify its structure

        document.getElementById('cart_items').value = JSON.stringify(cart);

        if (cart.length === 0) {
            alert('Cart is empty. Please add items to the cart before confirming the prescription.');
            window.location.href = 'cart.php?patient_name=<?php echo htmlspecialchars($patientName); ?>'; // Redirect to cart.php with patient_name
        } else {
            // Optionally, calculate and display total cost if your cart items have a price property
            let totalCost = cart.reduce((total, item) => {
                let itemPrice = item.medprice || 0;
                let itemQuantity = item.quantity || 1;
                return total + (itemPrice * itemQuantity);
            }, 0);
            document.getElementById('total-cost').textContent = `Total Cost: ₹${totalCost.toFixed(2)}`;
        } 
    });

    function validateCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert('Cart is empty. Please add items to the cart before confirming the prescription.');
            window.location.href = 'cart.php?patient_name=<?php echo htmlspecialchars($patientName); ?>'; // Redirect to cart.php with patient_name
            return false;
        }
        return true;
    }
</script>
