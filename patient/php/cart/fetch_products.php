<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicalproducts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
 
while ($row = $result->fetch_assoc()) {
    $medname = htmlspecialchars($row["product_name"]);
    $medprice = htmlspecialchars($row["product_price"]);
    $medimage = $row["product_image"]; // Assuming this is the binary data for the image
    $medid = htmlspecialchars($row["medid"]);

    echo '<div class="listProduct" data-product-id="' . $medid . '" data-product-name="' . $medname . '" data-product-price="' . $medprice . '" data-product-image="data:image/png;base64,' . base64_encode($medimage) . '">';
    echo '<img class="image" src="data:image/png;base64,' . base64_encode($medimage) . '" alt="' . $medname . '"/>';
    echo '<p class="name">' . $medname . '</p>';
    echo '<p class="price">₹' . $medprice . '</p>';
    echo '<button class="add">Add to cart</button>';
    echo '</div>';
}

// Close connection
$stmt->close();
$conn->close();
?>
