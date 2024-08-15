<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lab tests and checkups at MAYO. Find and book lab tests online.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Lab tests, medical tests, MAYO, online booking">
    <title>Labtests-MAYO</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="lab.css">
</head>
<body>
<header class="header">
    <a href="../html/home1.html" class="logo">MAYO</a>
    <div class="op">
        <div class="flex-container">
            <i class='bx bx-menu' id="menu-icon"></i>
            <div class="head-elements">
                <nav class="navbar">
                    <div class="compo">
                        <a href="con.html" class="con">CONSULT</a>
                        <div class="med">
                            <button class="medbtn">MEDICINES<i class="arrow right"></i></button>
                            <div class="medcon">
                                <a href="page1.html">BOOK MEDICINE</a>
                                <a href="page2.html">STATUS</a>
                                <a href="page3.html">VIEW MEDICINES</a>
                            </div>
                        </div>
                        <div class="lab">
                            <button class="labbtn">LAB TESTS<i class="arrow right"></i></button>
                            <div class="labcon">
                                <a href="page1.html">TAKE TEST</a>
                                <a href="page2.html">STATUS</a>
                                <a href="page3.html">VIEW TESTS</a>
                            </div>
                        </div>
                        <div class="rec">
                            <a href="appointment.html" class="recbtn">REQUEST APPOINTMENT</a>
                        </div>
                        <div class="log">
                            <a href="../php/register.php" class="log">LOGIN</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
    <div class="searchbar">
        <label for="search" class="search">
            Find Tests
        </label>
        <input type="search" class="search" id="searchInput" placeholder="Search Tests">
        <button class="searchbut" id="searchButton">
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
    </div>

<div class="iconcart">
    <img src="cartimage.png" alt="Cart Icon" id="cartIcon">
    <div class="totalQuantity">0</div>
    <div id="sparkleContainer"></div> 
</div>
    <div class="cart-container" id="cartBox">
    <button class="close-cart" id="closeCart">
    x
    </button>
        <h2>Cart</h2>
        <div class="cart-items"></div>
        <div class="cart-buttons">
            <a href="labcheckout.php" class="checkout-cart" id="checkout-cart">Checkout</a>
        </div>
        <div class="totalCost"></div>
    </div>

    <div class="item">
        <?php include 'fetch_test.php'; ?>
    </div>

    <script src="lab.js"></script>
</body>
</html>
