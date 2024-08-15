<?php
session_start();

// Ensure the session variable for patient ID is set
if (!isset($_SESSION['pid'])) {
    echo "Patient ID session variable is not set.";
    exit;
}
$patientId = $_SESSION['pid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lab tests and checkups at MAYO. Find and book lab tests online.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Lab tests, medical tests, MAYO, online booking">
    <title>Lab Tests - MAYO</title>
    <link rel="stylesheet" href="labcheckout.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="cart-summary-container">
        <div id="cart-summary"></div>
    </div>
    
    <div class="checkout-container">
        <h1>Checkout</h1>
        <form id="checkout-form">
            <input type="hidden" id="patient-id" name="patient_id" value="<?php echo htmlspecialchars($patientId); ?>">
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Enter your location" required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select id="state" name="state" required>
                    <option value="" selected disabled>Select state</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Maharastra">Maharastra</option>
                </select>
            </div>
            <div class="phonepe-box">
                <img src="phonepay.png" alt="PhonePe Logo" class="phonepe-logo">
                <img src="qrcode.jpg" alt="PhonePe QR Code" class="phonepe-qr">
                <button type="submit" id="pay-button" class="pay-button">Pay ₹0</button>
            </div>
        </form>
    </div>

    <script>
        // Pass the patient ID to JavaScript
        sessionStorage.setItem('pid', '<?php echo $patientId; ?>');
    </script>
    <script src="labcheckout.js"></script>
</body>
</html>