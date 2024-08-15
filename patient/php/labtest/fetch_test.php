<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product data
$sql = "SELECT * FROM labtest1";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Display product data
while ($row = mysqli_fetch_assoc($result)) {
    $labname = $row["testname"];
    $labprice = $row["testprice"];
    $labimage = $row["testimage"];
    $labid = $row["testid"];

    // Display product details and image
    echo '<div class="listProduct" data-product-id="' . $labid . '">';
    echo '<div class="item1">';
    echo '<div class="top">';
    echo '<img class="image" src="data:image/png;base64,' . base64_encode($labimage) . '" alt="' . htmlspecialchars($labname, ENT_QUOTES, 'UTF-8') . ' image" />';
    echo '<p class="name">' . htmlspecialchars($labname, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '</div>';
    echo '<div class="end">';
    echo '<p class="price">' . htmlspecialchars($labprice, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<button class="add" data-id="' . $labid . '">Add</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
$conn->close();
?>