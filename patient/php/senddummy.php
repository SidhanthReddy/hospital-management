<?php
$otp = rand(100000,999999);
                require "../Mail/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer;
                $email = 'learninghubjee@gmail.com';
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
                $mail->Subject="check1";
                $mail->Body="<p>Dear user, </p> <h3>palli 123 <br></h3>
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
                    </script>
                    <?php
                }
?>