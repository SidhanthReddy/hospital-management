<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $location = $_POST["location"];
    $phone = $_POST["phone"];
    $state = $_POST["state"];

    // Process the checkout logic (e.g., save to database, send confirmation email, etc.)
    // For demonstration purposes, let's just print the submitted data
    echo "<h2>Order Details:</h2>";
    echo "<p>Name: $name</p>";
    echo "<p>Location: $location</p>";
    echo "<p>Phone Number: $phone</p>";
    echo "<p>State: $state</p>";

    // You can add more processing logic here, such as saving the order to a database, sending email notifications, etc.
} else {
    // If the form is not submitted, redirect back to the checkout page
    header("Location: checkout.php");
    exit;
} 
?>
