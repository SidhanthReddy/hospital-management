<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Side Menu</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <style>
        html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        }

      iframe[iframetag] {
         border: none;  
         width:100%;
         height: 100vh;
      }
    </style>
    <div class="topnav">
        <a class="mayo">MAYO</a>
        <a href="#logout" id="logout-link">LOGOUT</a>
    </div>
    <div class="appoint">
    
    </div>
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Do you want to log out?</p>
            <button id="confirmLogout">Yes</button>
            <button id="cancelLogout">No</button>
        </div>
    </div>
    <div class="med-container">
 
        <iframe src="cart/cart.php" frameborder="0" iframetag></iframe>
    </div>
    <script src="../js/admindashboard.js"></script>
</body>
</html>