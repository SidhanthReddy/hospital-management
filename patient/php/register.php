<?php
session_start();
include('../connect/connection.php');

if(isset($_POST["register"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $gender = $_POST["gender"];
    $date = $_POST["date1"];
    $email = $_POST["email1"];
    $password = $_POST["newpass"];
    $phoneno = $_POST["phoneno"];
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address');</script>";
        exit; 
    }

    $check_query = mysqli_query($connect, "SELECT * FROM login11 where email ='$email'");
    $rowCount = mysqli_num_rows($check_query);

    if(!empty($email) && !empty($password)){
        if($rowCount > 0){
            ?>
            <script>
                alert("User with email already exists!");
            </script>
            <?php
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $result = mysqli_query($connect, "INSERT INTO login11(fname, lname, gender, birthdate, email, password, phoneno, status) VALUES ('$fname', '$lname', '$gender', '$date', '$email', '$hashed_password', '$phoneno', 0)");

            if($result){
                $otp = rand(100000,999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;
                require "../Mail/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer;
    
                $mail->isSMTP();
                $mail->Host='smtp.gmail.com';
                $mail->Port=587;
                $mail->SMTPAuth=true;
                $mail->SMTPSecure='tls';
    
                $mail->Username='sidhanthreddy2020@gmail.com';
                $mail->Password='qamf ndlp pyyd eeiu';
    
                $mail->setFrom('sidhanthreddy2020@gmail.com', 'OTP Verification');
                $mail->addAddress($email);
    
                $mail->isHTML(true);
                $mail->Subject="Your verify code";
                $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                <br><br>
                <p>With regards,</p>
                <b>Mayo Clinic</b>";
    
                if(!$mail->send()){
                    ?>
                    <script>
                        alert("Register Failed, Error sending email");
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        alert("Register Successfully, OTP sent to <?php echo $email; ?>");
                        window.location.replace('../html/notification.html');
                    </script>
                    <?php
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>

        </title>
        <link rel="stylesheet" href="../css/register.css">
        <script src="../js/validateFormjs"></script>
    </head>
    <body>
        <header class = header>
            <a href="../html/home1.php" class="logo">MAYO</a>
            <div class = "flex-container">
            
            <i class='bx bx-menu' id="menu-icon"></i>
            <div class = "head-elements">
            <nav class="navbar">
                <div class="compo">
                <a href="con.html" class = "con">CONSULT</a>
                <div class="med">
                    <button class="medbtn">MEDICINES<i class = "arrow right"></i></button>
                    <div class="medcon">
                    <a href="page1.html">Element 1</a>
                    <a href="page2.html">Element 2</a>
                    <a href="page3.html">Element 3</a>
                    </div>
                </div>
                <div class="lab">
                    <button class="labbtn">LAB TESTS<i class = "arrow right"></i></button>
                    <div class="labcon">
                    <a href="page1.html">Element 1</a>
                    <a href="page2.html">Element 2</a>
                    <a href="page3.html">Element 3</a>
                    </div>
                </div>
                <div class="rec">
                <a href="../html/appointment.php" class="recbtn" style="font-size: 13.5px;">
                REQUEST APPOINTMENT
            </a>
            </div>
                </div>
               
                </div>
                
            </div>
            </nav>
        </header>
        <script src = "../js/validateForm.js"></script>
        <div class = "top"></div>
        <div class = "form-container">
            <h1 class = "heading">
                Registration
            </h1>
        <form action="#" method = "post" name = "register" onsubmit="return validateForm()">
            <div>
            <label for = "fanme">First name:</label>
            <input type="text" id = "fname" name = "fname" placeholder="First Name" class = "fname" autocomplete="off"required>
            </div>
            <br>
            <div class = "two">
                <label for = "lname">Last name:</label>
                <input type = "text" id = "lname" name = "lname" placeholder = "Last Name" class = "lname" autocomplete="off" required>
            </div>
            <br>
            <div>
                <label for = "gender" required>Gender:</label>
                <input type = "radio" name = "gender" value = "Male" id = "Male" class = "gender1">
                <label>Male</label>
                <input type = "radio" name = "gender" value = "Female" id = "Female" class = "gender2">
                <label>Female</label>
                <input type = "radio" name = "gender" value = "Other" id = "Other" class = "gender3">
                <label>Other</label>
            </div>
            <br>
            <div>
                <label for = "date1">Enter your birth date:</label>
                <input type = "date" id = "date1" name = "date1" class = "date1" required>
            </div>
            <br>
            <div>
                <label for = "email1">E-mail:</label>
                <input type = "email" id = "email1" name = "email1" placeholder = "Ex:abc@gmail.com" class = "email1" autocomplete="off" required>
            </div>
            <br>
            <div>
                <label for = "newpass">Set password:</label>
                <input type = "text" id = "newpass" name = "newpass" placeholder = "Password" class = "newpass" autocomplete="off" required> 
            </div>
            <br>
            <div>
                <label for = "repass">Confirm password</label>:</label>
                <input type = "password" id = "repass" name = "repass" class = "repass" placeholder="Password" autocomplete="off" required>
            </div>
            <br>
            <div>
                <label for = "phone">Phone no:</label>
                <input type = "tel" id = "phoneno"  name = "phoneno" placeholder = "XXXXXXXXXX" class = "phoneno" autocomplete="off" required>
            </div>
            <br>
            <input type = "reset" class="reset">
            <input type="submit" name = "register" value = "Register" class="submit" onsubmit="return validateForm()">
            <br>
            <label class = "already">Already have an account?</label>
            <a href = "index.php" class = "login">
                Log in
            </a>
        </form>
    </div>

    </body>
</html>