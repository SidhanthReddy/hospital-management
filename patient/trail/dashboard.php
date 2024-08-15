<?php
// Check if logout parameter is set in the POST request
if (isset($_POST['logout'])) {
    error_log("Logout parameter received");

    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Send a response back to the JavaScript code
    echo "success";
    exit();
}
?>
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
    <div class="topnav">
        <a class="mayo">MAYO</a>
        <a href="#logout" id="logout-link">LOGOUT</a>
    </div>
    <p class="Appointments-tag">Appointments</p>
    <div class="appoint">
    <?php
session_start();
include('../connect/connection.php');
if (isset($_SESSION['did'])) {
    $doctorId = $_SESSION['did'];

    // Prepare and execute the SQL statement with JOIN
    $sql = "SELECT a.appointment_id, a.patient_id, a.appointment_date, a.appointment_time, a.booking_timestamp, d.fname, d.lname
            FROM appointments a
            JOIN login11 d ON a.patient_id = d.pid
            WHERE a.doctor_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    $currentAppointments = array();
    $upcomingAppointments = array();
    $expiredAppointments = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointmentDateTime = new DateTime($row['appointment_date'] . ' ' . $row['appointment_time']);
            $currentDateTime = new DateTime();
            $remainingTime = $currentDateTime->diff($appointmentDateTime);
            $minutesDiff = ($remainingTime->h * 60) + $remainingTime->i;

            if ($appointmentDateTime < $currentDateTime) {
                $expiredAppointments[] = $row;
            } elseif ($minutesDiff <= 15 && $minutesDiff >= 0) {
                $currentAppointments[] = $row;
            } else {
                $upcomingAppointments[] = $row;
            }
        }
    }

    // Display current appointments
    if (!empty($currentAppointments)) {
        echo "<p class='appoint-details'>Current Appointments</p>";
        foreach ($currentAppointments as $row) {
            echo "<div class='appbox current-appointment'>
                    <div class='appbox-content'>
                        <div class='appid'>Appointment ID: {$row['appointment_id']}</div>
                        <div class='docname'>Patient Name: {$row['fname']}</div>
                        <div class='date'>Appointment Date: {$row['appointment_date']}</div>
                        <div class='time'>Time: {$row['appointment_time']}</div>
                        <button class='add-prescription-btn' onclick='redirectToPrescription(\"{$row['fname']}\")'>Add Prescription</button>
                    </div>
                  </div>";
        }
    }

    // Display upcoming appointments
    if (!empty($upcomingAppointments)) {
        echo "<p class='appoint-details'>Upcoming Appointments</p>";
        foreach ($upcomingAppointments as $row) {
            $appointmentDateTime = new DateTime($row['appointment_date'] . ' ' . $row['appointment_time']);
            echo "<div class='appbox upcoming-appointment' id='upcoming-{$row['appointment_id']}'>
                    <div class='appbox-content'>
                        <div class='appid'>Appointment ID: {$row['appointment_id']}</div>
                        <div class='docname'>Patient Name: {$row['fname']}</div>
                        <div class='date'>Appointment Date: {$row['appointment_date']}</div>
                        <div class='exp' id='timer-{$row['appointment_id']}'></div>
                        <div class='time'>Time: {$row['appointment_time']}</div>
                    </div>
                  </div>";
            echo "<script>
                    var appointmentDateTime{$row['appointment_id']} = new Date('{$appointmentDateTime->format('Y-m-d H:i:s')}');
                  </script>";
        }
    }

    // Display expired appointments
    if (!empty($expiredAppointments)) {
        echo "<p class='appoint-details'>Expired Appointments</p>";
        foreach ($expiredAppointments as $row) {
            echo "<div class='appbox expired-appointment'>
                    <div class='appbox-content'>
                        <div class='appid'>Appointment ID: {$row['appointment_id']}</div>
                        <div class='docname'>Patient Name: {$row['fname']}</div>
                        <div class='date'>Appointment Date: {$row['appointment_date']}</div>
                        <div class='exp'>Appointment expired</div>
                    </div>
                  </div>";
        }
    }

    if (empty($currentAppointments) && empty($upcomingAppointments) && empty($expiredAppointments)) {
        echo "<p>No appointments found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>No patient ID found in session.</p>";
}
?>
</div>
<script>
// JavaScript function to handle "Checkout" button click
function redirectToCheckout(patientName) {
    // Construct the URL with patient's name as a query parameter
    var checkoutURL = 'cart/cart.php?patient_name=' + encodeURIComponent(patientName);
    
    // Redirect to checkout.php
    window.location.href = checkoutURL;
}

function updateTimers() {
    var currentDateTime = new Date();
    <?php
    if ($result && $result->num_rows > 0) {
        $result->data_seek(0); // Reset the result pointer
        while ($row = $result->fetch_assoc()) {
            echo "
            var timer{$row['appointment_id']} = document.getElementById('timer-{$row['appointment_id']}');
            if (timer{$row['appointment_id']}) {
                var remainingTime = Math.floor((appointmentDateTime{$row['appointment_id']}.getTime() - currentDateTime.getTime()) / 1000);
                var weeks = Math.floor(remainingTime / (3600 * 24 * 7));
                var days = Math.floor((remainingTime % (3600 * 24 * 7)) / (3600 * 24));
                var hours = Math.floor((remainingTime % (3600 * 24)) / 3600);
                var minutes = Math.floor((remainingTime % 3600) / 60);
                var seconds = remainingTime % 60;

                var timerText = 'Starts in ';
                if (weeks > 0) {
                    timerText += weeks + 'w ';
                }
                if (days > 0) {
                    timerText += days + 'd ';
                    timerText += hours + 'h ' + minutes + 'm';
                } else {
                    timerText += hours + 'h ' + minutes + 'm ' + seconds + 's';
                }

                timer{$row['appointment_id']}.textContent = timerText;
            }";
        }
    }
    ?>
}

setInterval(updateTimers, 1000);
</script>
</body>
</html>
