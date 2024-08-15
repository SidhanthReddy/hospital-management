<?php
include('../connect/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pid = $_POST['pid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];

    // Calculate age from birthdate
    $birthDateTimestamp = strtotime($birthdate);
    $age = (date('Y') - date('Y', $birthDateTimestamp)) - (date('md') < date('md', $birthDateTimestamp) ? 1 : 0);

    if ($age >= 18 && $age < 100) {
        $sql = "UPDATE `login11` SET `fname` = ?, `lname` = ?, `gender` = ?, `birthdate` = ?, `phoneno` = ?" . ($password ? ", `password` = ?" : "") . " WHERE `pid` = ?";
        $stmt = $connect->prepare($sql);

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssssi", $fname, $lname, $gender, $birthdate, $phoneno, $hashedPassword, $pid);
        } else {
            $stmt->bind_param("sssssi", $fname, $lname, $gender, $birthdate, $phoneno, $pid);
        }

        if ($stmt->execute()) {
            echo "<p>Details updated successfully.</p>";
            echo "<meta http-equiv='refresh' content='1.5;url=logout.php'>";
        } else {
            echo "<p>Error updating details: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Age must be between 18 and 99.</p>";
    }
}

$connect->close();
?>
