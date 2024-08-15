<?php
session_start();
include 'connection.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_SESSION['pid']; // Assuming 'pid' is the session variable for patient ID
    $cartItems = json_decode($_POST['cart_items'], true);
    $patientName = htmlspecialchars($_POST['patient_name']);
    $location = htmlspecialchars($_POST['location']);
    $state = htmlspecialchars($_POST['state']);
    $paymentMethod = htmlspecialchars($_POST['payment-method']);
    $confirm = $_POST['confirm'];

    $stmt = $connect->prepare("SELECT email FROM login11 WHERE pid = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if (empty($patientId)) {
        echo "Patient ID not found.";
        exit;
    }
    // Insert purchase into the database
    if ($confirm === 'yes') {
        // Start a transaction
        $connect->begin_transaction();

        try {
            // Insert into purchases table
            $stmt = $connect->prepare("INSERT INTO purchase(patient_id, location, state, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $patientId, $location, $state, $paymentMethod);
            $stmt->execute();
            $purchaseId = $stmt->insert_id; // Get the auto-incremented ID of the purchase
            $stmt->close();

            // Prepare and bind for inserting into purchase_items table
            $stmt = $connect->prepare("INSERT INTO purchase_items (purchase_id, medicine_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $purchaseId, $medicineId, $quantity, $price);

            // Insert each item in the cart into purchase_items table
            foreach ($cartItems as $item) {
                $medicineId = $item['medid'];
                $quantity = $item['quantity'];
                $price = $item['medprice']; // Assuming 'medprice' is the price of the medicine
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Commit the transaction
            $connect->commit(); 

            // Clear the cart items from local storage and redirect to dashboard or a success page
            echo '<script>
                localStorage.removeItem("cart");
                alert("Prescription added successfully. Redirecting to the dashboard...");
                window.location.href = "cart.php";
            </script>';
            $otp = rand(100000, 999999);
            require "../../Mail/phpmailer/PHPMailerAutoload.php";
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
            $mail->Subject = "Purchase Details";
            $mail->Body = "<p>Dear $patientName, </p> <h3>Your Purchase is successfull.<br></h3>
                <p>Your PurchaseID is <b>$purchaseId</b></p>
                <p>You may wait for the package for delievery or directly consult our pharmacy</p>
                <p> and confirm the purchase using your purchaseID.</p>
                <p>With regards,</p>
                <b>Mayo Clinic</b>";

            if (!$mail->send()) {
                echo "<script>alert('Failed to send email');</script>";
            } else {
                echo "<script>alert('Prescription added successfully. Confirmation has been sent to your email:$email');</script>";
            }


        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $connect->rollback();
            echo "Failed to add prescription: " . $e->getMessage();
        }
    } else {
        // Handle the case where the user chose 'no'
        header("Location: cart.php"); // Redirect back to cart or any appropriate page
        exit();
    }

    // Close database connection
    $connect->close();
}
?>
