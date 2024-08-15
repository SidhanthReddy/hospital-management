<?php
session_start();
include 'connection.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName = $_POST['patient_name'];
    $confirm = $_POST['confirm'];
    $cartItems = json_decode($_POST['cart_items'], true);

    // Check if session variable 'did' is set
    if (!isset($_SESSION['did'])) {
        echo "Doctor ID session variable is not set.";
        exit;
    }
    $doctorId = $_SESSION['did']; 

    // Fetch patient_id and email from login11 table using patientName
    $stmt = $connect->prepare("SELECT pid,email FROM login11 WHERE fname = ?");
    $stmt->bind_param("s", $patientName);
    $stmt->execute();
    $stmt->bind_result($patientId, $email);
    $stmt->fetch();
    $stmt->close();

    if (empty($patientId)) {
        echo "Patient ID not found.";
        exit;
    }

    if ($confirm === 'yes') {
        // Start a transaction
        $connect->begin_transaction();

        try {
            // Insert a new row into the prescriptions table to get the new ID
            $stmt = $connect->prepare("INSERT INTO prescriptions (doctor_id, patient_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $doctorId, $patientId);
            $stmt->execute();
            $newPrescriptionId = $stmt->insert_id; // Get the auto-incremented ID
            $stmt->close();

            // Prepare and bind for inserting into prescription_items table
            $stmt = $connect->prepare("INSERT INTO prescription_items (prescription_id, medicine_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $newPrescriptionId, $medicineId, $quantity, $price);

            // Insert each cart item into the prescription_items table
            foreach ($cartItems as $item) {
                $medicineId = $item['medid'];
                $quantity = $item['quantity'];
                $price = $item['medprice']; // Get the price of the medicine
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Commit the transaction
            $connect->commit();

            // Clear the cart items from local storage and redirect to dashboard
            echo '<script>
                localStorage.removeItem("cart");
                setTimeout(function() {
                    window.location.href = "../dashboard.php";
                }, 1500);
            </script>';
            echo "<script>Prescription added successfully. Redirecting to the dashboard...</script>";

            $otp = rand(100000, 999999);
            require "../Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = 'sidhanthreddy2020@gmail.com';
            $mail->Password = 'qamf ndlp pyyd eeiu';
            $mail->setFrom('sidhanthreddy2020@gmail.com', 'OTP Verification');
            $mail->addAddress($email); // Use the fetched email here
            $mail->isHTML(true);
            $mail->Subject = "Prescription Details";
            $mail->Body = "<p>Dear $patientName, </p> <h3>Your prescription has been added successfully.<br></h3>
                <p>Your PrescriptionID is <b>$newPrescriptionId</b></p>
                <p>Please consult our pharmacy to purchase the prescribed medications</p>
                <p>With regards,</p>
                <b>Mayo Clinic</b>";

            if (!$mail->send()) {
                echo "<script>alert('Failed to send email');</script>";
            } else {
                echo "<script>alert('Prescription added successfully. Email sent to $email');</script>";
            }

        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $connect->rollback();
            echo "Failed to add prescription: " . $e->getMessage();
        }
    } else {
        // Handle the case where the user chose 'no'
        header("Location:cart_page.php");
        exit();
    }

    $connect->close();
}
?>
