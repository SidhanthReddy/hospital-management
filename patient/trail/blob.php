<?php
// Database configuration
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "loginsystem";
$dbPort = 3307; // Specify the port number if it's not the default 3306

// Create a new MySQLi instance
$connect = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// SQL query to get the image BLOB
$sql = "SELECT image FROM t3 LIMIT 1"; // You might want to add a WHERE clause to select a specific image
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    // Fetch the image data
    $row = $result->fetch_assoc();
    $imageBlob = $row['image'];
} else {
    echo "No image found.";
    exit;
}

// Close the connection
$connect->close();

// Check if BLOB data is not empty
if (empty($imageBlob)) {
    echo "BLOB data is empty.";
    exit;
}

// Encode BLOB data to base64
$base64Image = base64_encode($imageBlob);

if (empty($base64Image)) {
    echo "Base64 encoding failed.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display BLOB Image</title>
</head>
<body>
    <?php if (isset($base64Image)): ?>
        <!-- Display the image using a data URI -->
        <img src="data:image/jpeg;base64,<?php echo $base64Image; ?>" alt="BLOB Image">
    <?php endif; ?>
</body>
</html>