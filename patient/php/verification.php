<?php session_start() ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel = "stylesheet" href = "../css/style.css">
    <title>Verification</title>
    <style>
        .login-form{
            margin-top: 100px;
        }
        .rec a
        {
            font-size: 13.5px;
        }
        </style>
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
                <a href = "../html/appointment.php"class="recbtn">REQUEST APPOINTMENT</a>
            </div>          
                </div>
               
                </div>
                
            </div>
            </nav>
            </div>
        </header>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verification Account</div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">OTP Code</label>
                                <div class="col-md-6">
                                    <input type="text" id="otp" class="form-control" name="otp_code" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Verify" name="verify">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
<?php 
    include('../connect/connection.php');
    if(isset($_POST["verify"])){
        $otp = $_SESSION['otp'];
        $email = $_SESSION['mail'];
        $otp_code = $_POST['otp_code'];

        if($otp != $otp_code){
            ?>
           <script>
               alert("Invalid OTP code");
           </script>
           <?php
        }else{
            mysqli_query($connect, "UPDATE login11 SET status = 1 WHERE email = '$email'");
            ?>
             <script>
                 alert("Verfiy account done, you may sign in now");
                   window.location.replace("index.php");
             </script>
             <?php
        }

    }

?>