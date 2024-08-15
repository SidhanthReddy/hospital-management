<?php
session_start(); // Start the session

// Include the connection file
$connectionPath = '../connect/connection.php';

if (file_exists($connectionPath)) {
    include($connectionPath);
} else {
    die("Connection file not found. Check the path and try again.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $did = $_POST['did'];
    $dpass = $_POST['dpass'];

    // Prepare and execute the SQL statement to prevent SQL injection
    $stmt = $connect->prepare("SELECT * FROM doctor1 WHERE did = ? AND password = ?");
    $stmt->bind_param("ss", $did, $dpass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Login successful, set the session variable
        $_SESSION['did'] = $did;
        echo "Login successful. Doctor ID set in session.";
        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed
        echo "Invalid ID or Password.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/dlogin.css">
</head>
<body>
    <!-- Particle background container -->
    <div id="particles-js"></div>
    <div class="loginBoxContainer">
    <div class="lbox">
        <p class="mayo">MAYO</p>
        <form action="" method="post">
            <label for="did">DoctorID:</label>
            <input type="text" name="did" id="did" class="did" required>
            <br>
            <label for="dpass">Password:</label>
            <input type="password" name="dpass" id="dpass" class="dpass" required>
            <br>
            <input type="submit" value="Login" class="submit">
        </form>
    </div>
    </div>

    <!-- Include the Particles.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="../js/particles-config.js"></script>
</body>
</html>

