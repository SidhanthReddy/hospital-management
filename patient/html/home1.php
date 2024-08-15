<!DOCTYPE html>
<?php
session_start(); 
include('../connect/connection.php');
if(isset($_SESSION['mail-id'])) {
  // Prepare and execute the query to fetch the first name based on email
  $email = $_SESSION['mail-id'];
  $sql = "SELECT pid,fname FROM login11 WHERE email = ?";
  $stmt = $connect->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if a row is returned
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION['fname'] = $row['fname'];
      $_SESSION['pid']=$row['pid'];
  }
}
?>

 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../css/home1.css">
    <title>Document</title>
</head>
<body>
  <style>
 .canvas {
      padding: 20px;
      text-align: center;
    }

    .spec {
      font-size: 43px;
      margin-bottom: 20px;
}
.block1 {
  margin-top: 80px;
  display: flex;
  align-items: flex-start; /* Align items to the start to prevent overlap */
  justify-content: left; /* Align items to the left */
  padding: 10px;
  gap: 10px; /* Space between the image and text */
}

.pic1con {
  max-width: 490px; /* Adjust the size as needed */
  height: 600px;
  border-radius: 10px;
  overflow: hidden; /* Hides the overflow to keep the zoom effect within bounds */
  flex-shrink: 0; /* Prevents the container from shrinking */
}

.pic1 {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ensures the image covers the entire container */
  transition: transform 1s ease; /* Smooth transition for the zoom effect */
}

.pic1con:hover .pic1 {
  transform: scale(1.15); 
}

.wor {
  align-self: flex-start; /* Align the text container at the start */
  margin-top: 100px;
  width: 550px;
  margin-left: 40px;
}

.worp1 {
  font-size: 30px;
}

.worp2 {
  font-size: 20px;
}
.block2 {
  margin-top: 60px;
  display: flex;
  align-items: flex-start; /* Align items to the start to prevent overlap */
  justify-content: left; /* Align items to the left */
  padding: 10px;
  gap: 20px; /* Increase space between the image and text */
}

.pic2con {
  max-width: 490px; /* Adjust the size as needed */
  height: 600px;
  overflow: hidden; /* Hides the overflow to keep the zoom effect within bounds */
  flex-shrink: 0; /* Prevents the container from shrinking */
  border-radius: 10px; /* Ensures the container has rounded corners */
}

.pic2 {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ensures the image covers the entire container */
  transition: transform 1s ease; /* Smooth transition for the zoom effect */
}

.pic2con:hover .pic2 {
  transform: scale(1.2); /* Zoom in on the image */
}

.cle {
  align-self: flex-start; /* Align the text container at the start */
  margin-top: 100px;
  width:550px;
  margin-right: 40px;
}

.cle1 {
  font-size: 30px;
}

.cle2 {
  font-size: 20px;
}

.block3 {
  margin-top: 60px;
  display: flex;
  align-items: flex-start; /* Align items to the start to prevent overlap */
  justify-content: left; /* Align items to the left */
  padding: 10px;
  gap: 10px; /* Space between the image and text */
}
  </style>
    <header class = header>
        <a href="#" class="logo">MAYO</a>
      <div class = "op">
        <div class = "flex-container">
        
        <i class='bx bx-menu' id="menu-icon"></i>
        <div class = "head-elements">
        <nav class="navbar">
            <div class="compo">
            <a href="con.html" class = "con">CONSULT</a>
            <div class="med">
              <a href="../php/cart/cart.php" class="medbtn">MEDICINES</a>
            </div>
            <div class="lab">
               <a href="../php/labtest/lab.php" class="labbtn">LAB TESTS</a>
            </div>
            <div class="rec">
                <a href = "../html/appointment.php"class="recbtn">REQUEST APPOINTMENT</a>
            </div>
              <?php
              if(isset($_SESSION['mail-id'])) {
                  // If the 'mail-id' session variable is set, display the dropdown button
                  echo '<div class="profile">';
                  echo '<button class="profilebtn">';
                  echo '<a href="../php/logout.php">'; // Added closing quote after href value
                  echo $_SESSION['fname'];
                  echo '</a>';
                  echo '</div>';
                  
            
              } else {
                  // If the 'mail-id' session variable is not set, display the login link
                  echo '<a href="../php/register.php" class="log" id = "log">LOGIN</a>';
              }
              ?>
            </div>
        </div>
        </nav>
        </div>
    </header>
    <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
              <img src="../images/b1.jpg" style="width:100%">
              <div class="text"></div>
            </div>
            <div class="mySlides fade">
              <img src="../images/b3.jpg" style="width:100%">
              <div class="text">WORLD-CLASS HOSPITALITY</div>
            </div>
            <div class="mySlides fade">
                <img src="../images/b4.jpg" style="width:100%">
                <div class="text">UTMOST CARE</div>
              </div>
              <div class="mySlides fade">
  
                <img src="../images/b2.jpg" style="width:100%">
                <div class="text">EXPEDITED MEDICAL RESPONSE</div>
              </div>
              <div class="mySlides fade">
                <img src="../images/b6.jpg" style="width:100%">
                <div class="text">PHARMATICAL EXPERTISE</div>
              </div>

              <div class="mySlides fade">
                <img src="../images/b5.jpg" style="width:100%">
                <div class="text">"THIS IS WHERE GREATNESS MEETS CARE" </div>
              </div>
            <div style="text-align:center">
                <span class="dot"></span> 
                <span class="dot"></span> 
                <span class="dot"></span> 
            </div>
          </div>
          <div class="about">
          <div>
            <p class = "mayo">MAYO CLINIC</p>
            <p class = "quote">-Where Miracles happen everyday</p>
          </div>
          
          <div class = "container">
          <div class="one">
          <p class = "head1">Our History</p>
          <p class = "para1">At Mayo Clinic, our mission is to inspire hope and contribute to health and well-being by providing the best care to every 
            patient through integrated clinical practice, education, and research.</p>
            <p class = "para11">We strive to deliver compassionate, 
            personalized care tailored to each individual's unique needs, fostering healing, innovation, and wellness in our communities and beyond.</p> 
        </div>
          <div class="two">
          <p class = "head2">Our Values</p>
          <p class = "para2">
            At Mayo Clinic, we prioritize patient-centered care, teamwork, excellence, integrity, and sustainability. </p>
           <p class = "para21"> We ensure high-quality care with compassion, respect, and dignity, collaborating across disciplines to innovate and deliver comprehensive solutions. 
            Upholding ethical standards, we manage resources responsibly to optimize efficiency and promote sustainability.</p>
        </div>
        <div class = "three">
        <p class = "head3">Our Achievements</p>
         <p class = "para3">
            Over the years, Mayo Clinic has achieved numerous milestones and accolades, solidifying its reputation as a leader in healthcare innovation and excellence. </p>
            
            <p class = "para31">From pioneering medical breakthroughs and surgical innovations to earning top rankings in national and international healthcare assessments, Mayo Clinic's contributions to medicine have made a profound impact on patients' lives worldwide
         </p>
        </div>
        <div class = "four">
         <p class = "head4">Our Global Impact</p>
         <p class = "para4">
            While Mayo Clinic's roots are deeply anchored in Rochester, Minnesota, its influence extends far beyond its home state and the borders of the United States.
            <p class = "para41">
             Mayo Clinic has established international collaborations, partnerships, and outreach initiatives aimed at advancing healthcare globally, sharing knowledge, expertise, and best practices with healthcare institutions and providers around the world.
         </p>
        </div>
    </div>
  </div>
  <div class="canvas">
    <p class = "spec">
      What do We specialize in?
    </p>
    
<div class="block1">
  <div class="pic1con">
    <img src="../images/a1.jpg" class="pic1" id="pic1" alt="none">
  </div>
  <div class="wor">
    <p class="worp1">World-class care</p>
    <p class="worp2">At Mayo Clinic, we are dedicated to providing world-class care with a patient-centered approach. Our expert teams create personalized treatment plans using the latest medical technology and research. With a focus on exceptional outcomes, we ensure each patient receives compassionate, high-quality care. Experience the Mayo Clinic difference, where innovation meets excellence.</p>
  </div>
</div>

<div class="block2">
  <div class="cle">
    <p class="cle1">Hygiene Excellence</p>
    <p class="cle2">At Mayo Clinic, we are dedicated to maintaining the highest standards of cleanliness and hygiene. Our expert teams ensure a safe and pristine environment for all patients, utilizing advanced cleaning protocols and technologies. Experience the Mayo Clinic difference, where hygiene meets excellence.</p>
  </div>
  <div class="pic2con">
    <img src="../images/a2.jpg" class="pic2" id="pic2" alt="none">
  </div>
</div>

<div class="block3">
<div class="pic1con">
    <img src="../images/a3.jpg" class="pic1" id="pic1" alt="none">
  </div>
  <div class="wor">
    <p class="worp1">Tender Care</p>
    <p class="worp2">At Mayo Clinic, we provide care with a motherly touch, ensuring each patient feels nurtured and supported. Our compassionate teams create a comforting and healing environment, offering personalized care that feels like home. Experience the Mayo Clinic difference, where tenderness meets professional excellence.</p>
  </div>
</div>





          
          
<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }

  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    

  slides[slideIndex-1].style.display = "block";  

  setTimeout(showSlides, 2100);
}

document.addEventListener("DOMContentLoaded", function() {
  // Function to check if an element is in the viewport
  function isInViewport(element) {
  const rect = element.getBoundingClientRect();
  return (
    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.bottom >= 0 &&
    rect.left <= (window.innerWidth || document.documentElement.clientWidth) &&
    rect.right >= 0
  );
}

  // Function to handle scroll event
  function handleScroll() {
    var elements = document.querySelectorAll('.pic1,.pic2,.pic3,.spec, .cle1, .cle2, .worp1, .worp2, .mayo, .quote, .head1, .head2, .head3, .head4, .para1, .para11, .para2, .para21, .para3, .para31, .para4, .para41,.canvas');

    elements.forEach(function(element) {
      if (isInViewport(element)) {
        element.classList.add('active');
      } //else {
      //  element.classList.remove('active');
      //}
    });
  }


  // Add scroll event listener
  window.addEventListener('scroll', handleScroll);

  // Initial check for elements on page load
  handleScroll();
});


    </script>
</body>
</html>