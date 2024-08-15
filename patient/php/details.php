<link rel="stylesheet" href="../css/logout.css">
<div class="topnav">
    <a href="../html/home1.php">MAYO</a>
    <a href="" onclick="showContent('logout', event)">LOGOUT</a>
    <a href="" onclick="showContent('appointments', event)">APPOINTMENTS</a>
    <a href="" onclick="showContent('prescriptions', event)">PRESCRIPTIONS</a>
    <a href="details.php">DETAILS</a>
</div>
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