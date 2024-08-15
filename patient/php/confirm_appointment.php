<?php
session_start();
include('../connect/connection.php');

// Step 1: Receive Data
$doctorName = $_POST['docname'];
$selectedDate = $_POST['selectedDate'];
$selectedSlot = $_POST['selectedSlot'];

// Step 2: Validate Data (You can add more validation as per your requirements)
if(empty($doctorName) || empty($selectedDate) || empty($selectedSlot)) {
    // Data is missing, return an error response
    http_response_code(400); // Bad request
    echo "Missing appointment details";
    exit;
}

// Step 3: Start Session (if not already started)

// Step 4: Retrieve session data (assuming you have a session variable named 'patient_id')
$patientId = $_SESSION['pid'];

// Step 5: Lookup doctor_id from login11 table based on doctor_name
$query = "SELECT did FROM doctor1 WHERE docname = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("s", $doctorName);
$stmt->execute();
$stmt->bind_result($doctorId);
$stmt->fetch();
$stmt->close();

// Step 6: date formatted
$formattedDate = date('Y-m-d', strtotime($selectedDate));
// Assuming you have a table named 'appointments' with columns 'patient_id', 'doctor_id', 'doctor_name', 'doctor_field', 'appointment_date', and 'appointment_time'
$query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
$stmt = $connect->prepare($query);
$stmt->bind_param("iiss", $patientId, $doctorId, $formattedDate, $selectedSlot);

if($stmt->execute()) {
    // Appointment successfully booked
        ?>
            <script>
                alert("Appointment successfully booked.");
            </script>
        <?php
} else {
    // Error occurred while booking appointment
    http_response_code(500); // Internal Server Error
    echo "Error booking appointment: " . $connect->error;
}

// Close statement and database connection
$stmt->close();
$connect->close();
?>
