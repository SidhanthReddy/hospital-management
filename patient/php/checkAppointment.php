    <?php
    include('../connect/connection.php');

    // Retrieve the date and doctor's name from the AJAX request
    $date = $_POST['date'];
    $docname = $_POST['doctor'];

    // Retrieve the doctor's ID from the doctor1 table based on the provided name
    $stmt = $conn->prepare("SELECT did FROM doctor1 WHERE docname = ?");
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the result (doctor's ID)
    if ($row = $result->fetch_assoc()) {
        $doctorId = $row['doctor_id'];
        // Prepare and execute the SQL query to check appointments
        $stmt = $conn->prepare("SELECT COUNT(*) AS numAppointments FROM appointments WHERE appointment_date = ? AND doctor_id = ?");
        $stmt->bind_param("si", $date, $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the result
        $row = $result->fetch_assoc();
        $numAppointments = $row['numAppointments'];

        // Return true if there are appointments, false otherwise
        echo ($numAppointments > 0) ? "true" : "false";
    } else {
        // Handle case where doctor name is not found
        echo "false"; // or any default value as needed
    }
    ?>
