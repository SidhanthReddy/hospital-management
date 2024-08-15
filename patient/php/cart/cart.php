<?php
session_start();

// Check if the session variable 'pid' is set
if(isset($_SESSION['pid'])) {
    $patientName = $_SESSION['pid'];
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lab tests and checkups at MAYO. Find and book lab tests online.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Lab tests, medical tests, MAYO, online booking">
    <title>Medicines-MAYO</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="../../css/home1.css">
</head>
<body>
    
    <div class="searchbar">
        <label for="search" class="search">
            Find Medicines
        </label>
        <input type="search" class="search" id="searchInput" placeholder="Search Medicines">
        <button class="searchbut" id="searchButton">
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
    </div>

<div class="iconcart">
    <img src="cartimage.png" alt="Cart Icon" id="cartIcon">
    <div class="totalQuantity">0</div>
    <div id="sparkleContainer"></div> <!-- Added for sparkle effect -->
</div>
    <div class="cart-container" id="cartBox">
    <button class="close-cart" id="closeCart">
    x
    </button>
        <h2>Cart</h2>
        <div class="cart-items"></div>
        <div class="cart-buttons">
            <a href="checkout.php" class="checkout-cart" id="checkout-cart">Checkout</a>
        </div>
        <div class="totalCost"></div>
    </div>
 
    <div class="item">
        <?php include 'fetch_products.php'; ?>
    </div>

    <script src="cart.js"></script>
<script>
    document.getElementById('checkout-cart').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the link
        
        // Check if session is active (you can replace this with your actual session check logic)
        var sessionActive = true; // Assuming session is active
        
        if (sessionActive) {
            window.location.href = 'checkout.php'; // Redirect to checkout.php
        } else {
            alert('Please log in to proceed.');
            window.location.href = 'login.php'; // Redirect to login.php
        }
    });
</script>

    </script>
</body>
</html>
