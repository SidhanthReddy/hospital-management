<?php
session_start();
include 'connection.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input) {
        $patientId = $input['id'];
        $location = $input['location'];
        $state = $input['state'];
        $items = $input['items'];

        // Fetch patient email from login11 table using patientId
        $stmt = $connect->prepare("SELECT email FROM login11 WHERE pid = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();

        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Patient email not found.']);
            exit;
        }

        // Start a transaction
        $connect->begin_transaction();

        try {
            // Insert a new row into the lab_purchase table to get the new ID
            $stmt = $connect->prepare("INSERT INTO lab_purchase (patient_id, location, state, status, created_at) VALUES (?, ?, ?, ?, NOW())");
            $status = 'Pending'; // Assuming a default status
            $stmt->bind_param("isss", $patientId, $location, $state, $status);
            $stmt->execute();
            $newPurchaseId = $stmt->insert_id; // Get the auto-incremented ID
            $stmt->close();

            // Prepare and bind for inserting into lab_purchase_items table
            $stmt = $connect->prepare("INSERT INTO lab_purchase_items (purchase_id, medid) VALUES (?, ?)");
            $stmt->bind_param("ii", $newPurchaseId, $medid);

            // Insert each item into the lab_purchase_items table
            foreach ($items as $item) {
                $name = $item['name'];
                $price = $item['price'];

                // Fetch medid from medicalproducts table using name
                $medidStmt = $connect->prepare("SELECT medid FROM medicalproducts WHERE name = ?");
                $medidStmt->bind_param("s", $name);
                $medidStmt->execute();
                $medidStmt->bind_result($medid);
                $medidStmt->fetch();
                $medidStmt->close();

                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Commit the transaction
            $connect->commit();

            // Send email with the purchase details
            require "../Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = 'your-email@gmail.com';
            $mail->Password = 'your-email-password';
            $mail->setFrom('your-email@gmail.com', 'Lab Purchase Confirmation');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Lab Purchase Details";
            $mail->Body = "<p>Dear Patient,</p><h3>Your lab purchase has been added successfully.<br></h3>
                <p>Your Purchase ID is <b>$newPurchaseId</b></p>
                <p>Please proceed to the lab for your tests.</p>
                <p>With regards,</p><b>Healthcare Lab</b>";

            if (!$mail->send()) {
                echo json_encode(['success' => false, 'message' => 'Failed to send email']);
            } else {
                echo json_encode(['success' => true, 'message' => 'Lab purchase added successfully. Email sent to ' . $email]);
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $connect->rollback();
            echo json_encode(['success' => false, 'message' => 'Failed to add lab purchase: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }

    $connect->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>