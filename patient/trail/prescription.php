<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptions</title>
    <style>
        /* Prescription box styles */
        .presc-box {
            border: 1px solid #ccc; /* Border */
            border-radius: 5px; /* Rounded corners */
            padding: 15px; /* Padding */
            margin-bottom: 20px; /* Add some space between prescription boxes */
            background-color: #fff; /* Background color */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a shadow */
        }

        /* Prescription ID style */
        .presc-id {
            font-weight: bold; /* Bold font weight */
            margin-bottom: 10px; /* Add space below prescription ID */
        }

        /* Patient name style */
        .patient-name {
            font-style: italic; /* Italic font style */
            margin-bottom: 5px; /* Add space below patient name */
        }

        /* Doctor name style */
        .doctor-name {
            font-weight: bold; /* Bold font weight */
            margin-bottom: 5px; /* Add space below doctor name */
        }

        /* Medicine container style */
        .medicine-container {
            display: flex; /* Use flexbox */
            flex-wrap: wrap; /* Wrap items to the next line if necessary */
            margin-bottom: 10px; /* Add space below medicine images */
        }

        /* Medicine item style */
        .medicine-item {
            margin-right: 10px; /* Add margin between images */
            margin-bottom: 10px; /* Add space below each medicine item */
        }

        .medicine-item img {
            max-width: 100px; /* Limit image width */
            height: auto; /* Maintain aspect ratio */
        }

        /* Quantity style */
        .quantity {
            font-weight: bold; /* Bold font weight */
        }
    </style>
</head>
<body>
    <h3>PRESCRIPTIONS</h3>

    <div class="appoint">
        <?php
        include('../connect/connection.php');

        // Set patient ID
        $patientId = 3;

        // Prepare and execute the SQL statement with JOIN
        $sql = "SELECT p.id AS prescription_id, l.fname AS patient_name, m.product_name, m.product_image AS medicine_image, pi.quantity, d.docname AS doctor_name
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
                    echo "<img src='data:image/png;base64," . base64_encode($details['medicine_image']) . "' alt='{$details['product_name']}'>";
                    echo "<div class='product-name'>Product Name: {$details['product_name']}</div>";
                    echo "<div class='quantity'>Quantity: {$details['quantity']}</div>";
                    echo "</div>"; // Closing div for medicine-item
                }
                echo "</div>"; // Closing div for medicine-container

                echo "</div>"; // Closing div for presc-box
            }
        } else {
            echo "<p>No prescriptions found.</p>";
        }
        $stmt->close();
        ?>
    </div>
</body>
</html>
