<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files for database connection
include('../connect/connection.php');

// Initialize bookedSlots array
$bookedSlots = array();

// Check if the request is a POST request and if the selectedDate parameter is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedDate'])) {
    // Sanitize the input to prevent SQL injection
    $selectedDate = mysqli_real_escape_string($connect, $_POST['selectedDate']);

    // Query to fetch booked slots for the selected date
    $query = "SELECT appointment_time FROM appointments WHERE appointment_date = '$selectedDate'";

    // Execute the query
    $result = mysqli_query($connect, $query);

    if ($result) {
        // Fetch booked slots
        while ($row = mysqli_fetch_assoc($result)) {
            $bookedSlots[] = $row['appointment_time'];
        }

        // Generate JavaScript code to output bookedSlots
        echo 'var bookedSlots = ' . json_encode($bookedSlots) . ';';
    } else {
        // Handle query execution error
        echo "// Error: " . mysqli_error($connect);
    }
}

// Reset bookedSlots to an empty array if the request is not a POST request or if selectedDate parameter is not set
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['selectedDate'])) {
    $bookedSlots = array();
}

// Close the connection after finishing sending data
header('Connection: close');
?>
