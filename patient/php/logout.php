<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    // Unset session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Unset session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Redirect to home page
    header("Location: ../html/home1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link rel="stylesheet" href="../css/logout.css">
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            background: rgb(240,248,255);
            background: linear-gradient(90deg, rgba(240,248,255,1) 0%, rgba(168,190,255,1) 90%);
            overflow-x: hidden;
        }


        .topnav {
            width: 100%;
            background-color: #f0f8ff;
            overflow: hidden;
            height: 73.5px;
        }

        .topnav a {
            float: right;
            display: block;
            color: black;
            text-align: center;
            text-decoration: none;
            margin-top: 27.5px;
            margin-left: 10px;
            font-size: 13.5px;
            margin-right: 10px;
        }
        .topnav a:hover
        {
            text-decoration: underline;
        }
        .topnav a:first-child {
            float: left;
            margin-left: 50px; /* Remove margin-left for the first child to keep it aligned to the left */
        }

        .main {
            padding: 20px;
        }

        .content{
            display: none;
        }

        .content.active {
            display: block;
        }
        .exp
        {
            margin-top: 10px;
            margin-left: 5px;
            color: red;
        }
        .appoint
        {
            padding:10px;
            width: 100%;
            position: absolute;
            display: flex; /* Use Flexbox */
            flex-wrap: wrap; /* Allow wrapping to next line */
            justify-content: center;
            max-width: 100%;
        }
        .appbox {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: white;
            width: calc(25% - 10px); /* Adjust as needed for four boxes in a row */
            max-width: 400px;
            margin-right: 20px;
        }

        .appid, .docname, .field, .date, .time, .booking_timestamp {
            margin: 5px 0;
            padding: 5px;
        }

        .appid {
            font-weight: bold;
            color: #333;
        }

        .docname {
            color: #007bff;
        }

        .field {
            color: #28a745;
        }

        .date, .time, .booking_timestamp {
            color: #6c757d;
        }

        .past-appointment {
            background-color: rgb(240, 240, 240); /* Greyish background for past appointments */
            color: rgb(240, 240, 240); /* Greyish text for past appointments */
        }
        .patient-details {
    border: 1px solid #ccc;
    padding: 20px;
    margin: 20px auto; /* Use 'auto' for the left and right margins to center the element */
    background-color: #f9f9f9;
    width: 400px;
    border-radius: 6px;
}
    .patient-details h2 {
        margin-top: 10px;
    }
    .patient-details p {
        margin: 20px 0;
        width: 400px;
        font-size: 15px;
    }
    .patient-details .label {
        font-weight: bold;
        color: #333;
    }
    .patient-details input, .patient-details select {
        margin-left: 10px;
    }
    .patient-details input[readonly], .patient-details select[disabled] {
        background-color: #e9ecef;
        color: #495057;
    }
    </style>
</head>
<body>
<div class="topnav">
    <a href="../html/home1.php">MAYO</a>
    <a href="" onclick="showContent('logout', event)">LOGOUT</a>
    <a href="" onclick="showContent('appointments', event)">APPOINTMENTS</a>
    <a href="" onclick="showContent('prescriptions', event)">PRESCRIPTIONS</a>
    <a href="" onclick="showContent('details', event)">DETAILS</a>
</div>
    <div class="main">
    <section id="details" class="content active">
    <?php
    include('../connect/connection.php');
    if (isset($_SESSION['pid'])) {
        $patientId = $_SESSION['pid'];
        $sql = "SELECT `pid`, `fname`, `lname`, `gender`, `birthdate`, `email`, `phoneno` FROM `login11` WHERE pid = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <div class="patient-details">
                <h2>Patient Details</h2>
                <form id="patientForm" method="post" action="update_patient.php">
                    <p><span class="label">First Name:</span> <input type="text" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" readonly></p>
                    <p><span class="label">Last Name:</span> <input type="text" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" readonly></p>
                    <p><span class="label">Gender:</span> 
                        <select name="gender" disabled>
                            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </p>
                    <p><span class="label">Birthdate:</span> <input type="date" name="birthdate" value="<?php echo htmlspecialchars($row['birthdate']); ?>" readonly></p>
                    <p><span class="label">Email:</span> <?php echo htmlspecialchars($row['email']); ?></p>
                    <p><span class="label">Phone Number:</span> <input type="text" name="phoneno" value="<?php echo htmlspecialchars($row['phoneno']); ?>" readonly></p>
                    <p><span class="label">New Password (optional):</span> <input type="password" name="password" readonly></p>
                    <input type="hidden" name="pid" value="<?php echo htmlspecialchars($row['pid']); ?>">
                    <p><input type="submit" value="Update Details" style="display:none;" id="updateButton"></p>
                </form>
                <button id="editButton" onclick="enableEditing()">Make Changes</button>
            </div>
            <?php
        } else {
            echo "<p>No patient details found.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>No patient ID set in session.</p>";
    }
    ?>

</section>
        <section id="prescriptions" class="content">
        <?php


// Check if the patient ID is set in the session
if (!isset($_SESSION['pid'])) {
    // Redirect to login page or handle the case where patient ID is not set
    header("Location: login.php"); // Adjust the URL if necessary
    exit();
}

include('../connect/connection.php');

// Get patient ID from the session
$patientId = $_SESSION['pid'];

// Prepare and execute the SQL statement with JOIN
$sql = "SELECT p.id AS prescription_id, l.fname AS patient_name, m.product_name, m.product_image AS medicine_image, pi.quantity, pi.price, d.docname AS doctor_name
        FROM prescriptions p
        JOIN prescription_items pi ON p.id = pi.prescription_id
        JOIN medicalproducts m ON pi.medicine_id = m.medid
        JOIN login11 l ON p.patient_id = l.pid
        JOIN doctor1 d ON p.doctor_id = d.did
        WHERE p.patient_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $prescriptions = []; // Array to hold prescriptions with the same ID
    while ($row = $result->fetch_assoc()) {
        $prescriptionId = $row['prescription_id'];
        if (!isset($prescriptions[$prescriptionId])) {
            $prescriptions[$prescriptionId] = [];
        }
        // Add prescription details to the array
        $prescriptions[$prescriptionId][] = $row;
    }
    echo "<p class ='presc-head'>Prescriptions</p>";
    // Loop through prescriptions
    foreach ($prescriptions as $prescriptionId => $prescriptionDetails) {
        echo "<div class='presc-box'>";
        echo "<div class='presc-id'>Prescription ID: $prescriptionId</div>";

        // Display patient name and doctor name only once per prescription ID
        echo "<div class='patient-name'>Patient Name: {$prescriptionDetails[0]['patient_name']}</div>";
        echo "<div class='doctor-name'>Doctor Name: {$prescriptionDetails[0]['doctor_name']}</div>";
        
        // Container for medicine images and quantity
        echo "<div class='medicine-container'>";
        foreach ($prescriptionDetails as $details) {
            echo "<div class='medicine-item'>";
            echo "<div class = 'image-con'><img src='data:image/png;base64," . base64_encode($details['medicine_image']) . "' alt='{$details['product_name']}'></div>";
            echo "<div class='product-name'>Product Name: {$details['product_name']}</div>";
            echo "<div class='quantity'>Quantity: {$details['quantity']}</div>";
            echo "</div>"; // Closing div for medicine-item
        }
        $totalPrice = 0; // Initialize total price for each prescription
        foreach ($prescriptionDetails as $details) {
            // Increment total price by (quantity * price) for each item
            $totalPrice += $details['quantity'] * $details['price'];
        }
        // Display the total price
        echo "<div class='total-price'>Total Price: $totalPrice</div>";
        echo "</div>"; // Closing div for medicine-container

        echo "</div>"; // Closing div for presc-box
    }
} else {
    echo "<p>No prescriptions found.</p>";
}
$stmt->close();
?>

        </section>
        <section id="appointments" class="content">
        <p style="font-size: 28px;">
            Appointments
        </p>
            <div class="appoint">
            <?php
            include('../connect/connection.php');

            // Ensure session variable is set
            if (isset($_SESSION['pid'])) {
                $patientId = $_SESSION['pid'];

                // Prepare and execute the SQL statement with JOIN
                $sql = "SELECT a.appointment_id, a.doctor_id, a.appointment_date, a.appointment_time, a.booking_timestamp, d.docname, d.field
                        FROM appointments a
                        JOIN doctor1 d ON a.doctor_id = d.did
                        WHERE a.patient_id = ?";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("i", $patientId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $appointmentDate = new DateTime($row['appointment_date']);
                        $currentDate = new DateTime();
                        $isPast = $appointmentDate < $currentDate ? "past-appointment" : "";
                        $showDetails = $appointmentDate >= $currentDate;
            
                        echo "
                        <div class='appbox {$isPast}'>
                            <div class='appid'>Appointment ID: {$row['appointment_id']}</div>
                            <div class='docname'>Doctor Name: {$row['docname']}</div>
                            <div class='field'>Field: {$row['field']}</div>
                            <div class='date'>Date: {$row['appointment_date']}</div>
                            <div class='booking_timestamp'>Booked on: {$row['booking_timestamp']}</div>";
                            
                        if ($showDetails) {
                            echo "<div class='time'>Time: {$row['appointment_time']}</div>";
                        }
                        else{
                            echo "<div class = 'exp'>Appointment already expired</div>";
                        }
            
                        echo "</div>";
                    }
                } else {
                    echo "<p>No appointments found.</p>";
                }
                $stmt->close();
            } else {
                echo "<p>No patient ID found in session.</p>";
            }
            ?>
            </div>

        </section>
        <section id="logout" class="content">
            <div class="logoutbody">
                <h2>Logout Confirmation</h2>
                <p>Are you sure you want to log out?</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="logout" value="Yes, Log me out">
                    <button onclick="window.location.href='../html/home1.php';return false;">No, Take me back</button>
                </form>
            </div>
        </section>

    </div>
    <script>
function showContent(id, event) {
event.preventDefault();
event.stopPropagation();

const contents = document.querySelectorAll('.content');
contents.forEach(content => {
content.classList.remove('active');
});

const selectedContent = document.getElementById(id);
selectedContent.classList.toggle('active');
}
function enableEditing() {
        const form = document.getElementById('patientForm');
        const inputs = form.querySelectorAll('input');
        const selects = form.querySelectorAll('select');
        inputs.forEach(input => input.removeAttribute('readonly'));
        selects.forEach(select => select.removeAttribute('disabled'));
        document.getElementById('updateButton').style.display = 'block';
        document.getElementById('editButton').style.display = 'none';
    }

    </script>
</body>
</html>

