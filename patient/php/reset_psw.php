<?php session_start() ;
include('../connect/connection.php');
?>
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel = "stylesheet" href = "../css/style.css">
    <title>Login Form</title>
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
                
            <style>
                .login-form
                {
                    margin-top:100px
                }
                body{
    background: linear-gradient(90deg,  #f2fafc 0%, rgb(226, 242, 247) 30%,rgb(211, 235, 255) 65%);
    position: relative;
}
body::-webkit-scrollbar
{
    display: none;
}
                </style>
        </header>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Your Password</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="login">

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required autofocus>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Reset" name="reset">
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
    if(isset($_POST["reset"])){
        include('connect/connection.php');
        $psw = $_POST["password"];

        $token = $_SESSION['token'];
        $Email = $_SESSION['email'];

        $hash = password_hash( $psw , PASSWORD_DEFAULT );

        $sql = mysqli_query($connect, "SELECT * FROM login11 WHERE email='$Email'");
        $query = mysqli_num_rows($sql);
  	    $fetch = mysqli_fetch_assoc($sql);

        if($Email){
            $new_pass = $hash;
            mysqli_query($connect, "UPDATE login11 SET password='$new_pass' WHERE email='$Email'");
            ?>
            <script>
                window.location.replace("index.php");
                alert("<?php echo "your password has been succesful reset"?>");
            </script>
            <?php
        }else{
            ?>
            <script>
                alert("<?php echo "Please try again"?>");
            </script>
            <?php
        }
    }

?>
<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>
