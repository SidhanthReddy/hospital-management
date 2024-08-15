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
$doctorId = $_SESSION['did'];

// Get server time
$serverTime = new DateTime();
$serverTimestamp = $serverTime->getTimestamp();

// Prepare and execute the SQL statement with JOIN
$sql = "SELECT a.appointment_id, a.patient_id, a.appointment_date, a.appointment_time, a.booking_timestamp, d.fname, d.lname
        FROM appointments a
        JOIN login11 d ON a.patient_id = d.pid
        WHERE a.doctor_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$result = $stmt->get_result();

$allAppointments = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointmentDateTime = new DateTime($row['appointment_date'] . ' ' . $row['appointment_time']);
        $row['appointment_datetime'] = $appointmentDateTime->format('Y-m-d H:i:s');
        $allAppointments[] = $row;
    }
}

// Pass all appointments and server time to JavaScript
echo "<script>
        var allAppointments = " . json_encode($allAppointments) . ";
        var serverTime = " . $serverTimestamp . ";
      </script>";

$stmt->close();
?>
</div>
<div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Do you want to log out?</p>
            <button id="confirmLogout">Yes</button>
            <button id="cancelLogout">No</button>
        </div>
    </div>
    <script src="../js/admindashboard.js"></script>
</head>
<body>

    <div class="appoint" id="appoint-container">
        <div id="current-appointments">
            <p class='appoint-details'>Current Appointments</p>
        </div>
        <div id="upcoming-appointments">
            <p class='appoint-details'>Upcoming Appointments</p>
        </div>
        <div id="expired-appointments">
            <p class='appoint-details'>Expired Appointments</p>
        </div>
    </div>
    <script>

 function renderAppointments() {
    var currentContainer = document.getElementById('current-appointments');
    var upcomingContainer = document.getElementById('upcoming-appointments');
    var expiredContainer = document.getElementById('expired-appointments');
    
    currentContainer.innerHTML = "<p class='appoint-details'>Current Appointments</p>";
    upcomingContainer.innerHTML = "<p class='appoint-details'>Upcoming Appointments</p>";
    expiredContainer.innerHTML = "<p class='appoint-details'>Expired Appointments</p>";

    var currentDateTime = getCurrentDateTime();

    allAppointments.forEach(function(appointment) {
        var appointmentDateTime = new Date(appointment.appointment_datetime);
        var remainingTime = (appointmentDateTime - currentDateTime) / 1000;
        var minutesDiff = Math.floor(remainingTime / 60);
        var minutesPast = Math.floor(-remainingTime / 60);
        console.log("Appointment ID: " + appointment.appointment_id + ", Remaining Time: " + remainingTime + "s, Minutes Past: " + minutesPast);

        var appointmentId = appointment.appointment_id;
        var appboxId = 'appbox-' + appointmentId;
        var timerId = 'timer-' + appointmentId;
        var buttonId = 'button-' + appointmentId;

        var appointmentHtml = "<div class='appbox-content'>" +
                              "<div class='appid'>Appointment ID: " + appointmentId + "</div>" +
                              "<div class='docname'>Patient Name: " + appointment.fname + "</div>" +
                              "<div class='date'>Appointment Date: " + appointment.appointment_date + "</div>" +
                              "<div class='time'>Time: " + appointment.appointment_time + "</div>" +
                              "<div class='exp' id='" + timerId + "'></div>" +
                              "</div>";

        var appboxElement = document.getElementById(appboxId);
        if (!appboxElement) {
            // Create appbox if it doesn't exist
            appboxElement = document.createElement('div');
            appboxElement.id = appboxId;
            appboxElement.className = 'appbox';
            appboxElement.innerHTML = appointmentHtml;
            upcomingContainer.appendChild(appboxElement);
        } else {
            // Update existing appbox content
            appboxElement.innerHTML = appointmentHtml;
        }

        // Update the timer element or add it if it doesn't exist
        var timerElement = document.getElementById(timerId);
        if (!timerElement) {
            timerElement = document.createElement('div');
            timerElement.id = timerId;
            timerElement.className = 'exp';
            appboxElement.querySelector('.appbox-content').appendChild(timerElement);
        }

        if (remainingTime < 0 && minutesPast > 15) {
            appboxElement.className = 'appbox expired-appointment';
            expiredContainer.appendChild(appboxElement);
        } else if (remainingTime < 0 && minutesPast <= 15) {
            appboxElement.className = 'appbox current-appointment';
            
            // Add the button only if it is a current appointment
            var buttonElement = document.createElement('button');
            buttonElement.id = buttonId;
            buttonElement.className = 'add-prescription-btn';
            buttonElement.onclick = function() { redirectToPrescription(appointment.fname); };
            buttonElement.textContent = 'Add Prescription';
            appboxElement.querySelector('.appbox-content').appendChild(buttonElement);
            
            currentContainer.appendChild(appboxElement);
        } else {
            appboxElement.className = 'appbox upcoming-appointment';
            upcomingContainer.appendChild(appboxElement);
            updateTimer(timerId, remainingTime, appointment);
        }
    });
}

function updateTimer(timerId, remainingTime, appointment) {
    var timerElement = document.getElementById(timerId);
    if (!timerElement) return;

    var interval = setInterval(function() {
        remainingTime -= 1;
        var elapsedTime = -remainingTime; // Time elapsed since the appointment time in seconds
        var minutesPast = Math.floor(elapsedTime / 60); // minutes past the appointment time

        var weeks = Math.floor(remainingTime / (3600 * 24 * 7));
        var days = Math.floor((remainingTime % (3600 * 24 * 7)) / (3600 * 24));
        var hours = Math.floor((remainingTime % (3600 * 24)) / 3600);
        var minutes = Math.floor((remainingTime % 3600) / 60);
        var seconds = Math.floor(remainingTime % 60);

        var timerText = 'Starts in ';
        if (remainingTime >= 0) {
            if (weeks > 0) {
                timerText += weeks + 'w ';
            }
            if (days > 0) {
                timerText += days + 'd ';
            }
            timerText += hours + 'h ' + minutes + 'm ' + seconds + 's';
        } else {
            timerText = 'Started ' + minutesPast + ' minutes ago';
        }

        timerElement.textContent = timerText;

        if (remainingTime <= -15 * 60 || remainingTime <= 0) { // 15 minutes past the appointment time
            clearInterval(interval);
            renderAppointments(); // Re-render appointments to update their status
        }
    }, 1000);
}


function redirectToPrescription(patientName) {
    var prescriptionURL = 'cart/cart.php?patient_name=' + encodeURIComponent(patientName);
    window.location.href = prescriptionURL;
}

// Calculate client-server time difference
var clientTime = Math.floor(Date.now() / 1000); // in seconds
var timeDiff = serverTime - clientTime;

function getCurrentDateTime() {
    var now = new Date();
    now.setSeconds(now.getSeconds() + timeDiff); // Adjust with server time difference
    return now;
}

// Initial render
renderAppointments();

// Re-render every minute to ensure appointments are updated
setInterval(renderAppointments, 60000);

    </script>
    
</body>
</html>
