<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check conne
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Check if product ID is received
if (isset($_POST['productId'])) {
    // Get product ID from form submission
    $productId = $_POST['productId'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Add product to cart session or database (for example, adding to a session variable)
    $_SESSION['cart'][] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price']
    );

    header('Location: cart.php');
    exit();
} else {
    // Handle error if product ID is not received
    echo "Error: Product ID not received";
}
?>
