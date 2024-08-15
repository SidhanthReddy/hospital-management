<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../connect/connection.php');

$selectedDate = $_POST['selectedDate'];
$docname = $_POST['docname'];

// Retrieve the doctor's ID from the doctor1 table based on the provided name
$stmt = $connect->prepare("SELECT did FROM doctor1 WHERE docname = ?");
if (!$stmt) {
    echo json_encode(['error' => 'Prepare statement failed: ' . $connect->error]);
    exit;
}
$stmt->bind_param("s", $docname);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
if ($row = $result->fetch_assoc()) {
    $doctorId = $row['did'];

    // Prepare and execute the SQL query to fetch booked slots
    $stmt = $connect->prepare("SELECT appointment_time FROM appointments WHERE appointment_date = ? AND doctor_id = ?");
    if (!$stmt) {
        echo json_encode(['error' => 'Prepare statement failed: ' . $connect->error]);
        exit;
    }
    $stmt->bind_param("si", $selectedDate, $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row['appointment_time'];
    }
}

// Return booked slots as JSON
header('Content-Type: application/json');
echo json_encode($bookedSlots);
?>
