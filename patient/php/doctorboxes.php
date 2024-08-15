<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data 
$sql = "SELECT docname,field,experience,achievements,price FROM doctor1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $docname = $row["docname"];
        $field = $row["field"];
        $experience = $row["experience"];
        $achievements = $row["achievements"];
        $price = $row["price"];
?>

<div class="doctor-box">
    <p class="docname">Doctor Name: <?php echo $docname; ?></p>
    <p class="field">Field: <?php echo $field; ?></p>
    <p class="experience">Experience: <?php echo $experience; ?> years</p>
    <p class="achievements">Achievements: <?php echo $achievements; ?></p>
    <p class="price">Price: ₹<?php echo $price; ?></p>
    <button class="appointment_btn"  onclick="openSideWindow('<?php echo $docname; ?>', '<?php echo $field; ?>')">Book Appointment</button>
</div>

<?php
    }
} else {
    echo "0 results";
}
$conn->close();
?>