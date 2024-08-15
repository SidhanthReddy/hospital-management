<?php 
session_start();
include('../connect/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "../css/appointment.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

   <style>
      iframe[iframetag] {
         border: none;
         width:500px;
         height: 600px;
      }
      .medbtn,.labbtn
      {
        font-size: 13px;
      }
   </style>
</head>
<body>
<header class = header>
        <a href="home1.php" class="logo">MAYO</a>
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
    <div class="searchbar">
        <label for class = "search">
            Find Doctors
        </label>
        <input type = "search" class = "search" id = "searchInput"placeholder="Search Doctors">
        <button class = "searchbut">
            <svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
        <select id="fieldFilter" class = "fieldFilter">
    <option value="">All Fields</option>
    <?php
    include('../connect/connection.php'); // Include the connection file

    // SQL query to fetch unique fields from the doctor1 table
    $sql = "SELECT DISTINCT field FROM doctor1";
    $result = $connect->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Loop through results and output options
        while ($row = $result->fetch_assoc()) {
            $field = $row['field'];
            echo "<option value=\"$field\">$field</option>";
        }
    } else {
        echo "<option disabled>No fields available</option>";
    }

    // Close the database connection
    $connect->close();
    ?>
</select>
<label for="sortCriterion" class = "sort">Sort by:</label>
<select id="sortCriterion" class="sortCriterion">
    <option value="">None</option>
    <option value="experience">Experience</option>
    <option value="price">Price</option>
</select>
<select id="sortOrder" class="sortOrder">
    <option value="asc">Ascending</option>
    <option value="desc">Descending</option>
</select>

</div>


    <div class="doccontainer">
        <?php include '../php/doctorboxes.php'; ?>
    </div>
    
    <div id="modal" class="modal">
        <span class="close" onclick="closeSideWindow()">&times;</span>
        <div class="details">
        <div class="modaldocname"></div>
        <div class="modalfield"></div>
        <div class="confirm-div"><button class = "confirm" id = "submitButton" name = "submit" >Confirm appointment</button></div>
      </div>
        <div id="iframeDiv">
             <iframe src="../html/datechooser.html"  id="dateChooserFrame" iframetag></iframe>
        </div>
    </div>
    <!-- Modal HTML -->
<div id="sessionModal" class="loginmodal">
    <div class="logincontent">
        <span class="clogin">&times;</span>
        <h3>MAYO</h3>
        <p>Session is not active. Please log in to book an appointment.</p>
        <a href = "../php/register.php"><button class = "register_btn">LOG IN</button></a>
    </div>
</div>
<script>
// Function to handle filtering
function handleFiltering() {
    console.log("handleFiltering function called");

    var searchInput = document.getElementById('searchInput').value.toLowerCase();
    var selectedField = document.getElementById('fieldFilter').value.toLowerCase();
    var doctorBoxes = document.querySelectorAll('.doccontainer .doctor-box');
    
    doctorBoxes.forEach(function(doctorBox) {
        var docname = doctorBox.querySelector('.docname').textContent.toLowerCase();
        var experience = doctorBox.querySelector('.experience').textContent.toLowerCase();
        var achievements = doctorBox.querySelector('.achievements').textContent.toLowerCase();
        var price = doctorBox.querySelector('.price').textContent.toLowerCase();
        var field = doctorBox.querySelector('.field').textContent.toLowerCase();
        
        var matchesSearch = docname.includes(searchInput) || experience.includes(searchInput) || achievements.includes(searchInput) || price.includes(searchInput);
        var matchesField = selectedField === '' || field.includes(selectedField);

        if (matchesSearch && matchesField) {
            doctorBox.style.display = 'block'; // Show the doctor box
        } else {
            doctorBox.style.display = 'none'; // Hide the doctor box
        }
    });
}

// Event listeners for search input changes and field selection changes
document.getElementById('searchInput').addEventListener('input', handleFiltering);
document.getElementById('fieldFilter').addEventListener('change', handleFiltering);

// Function to handle sorting
function handleSorting() {
    console.log("handleSorting function called");

    var sortCriterion = document.getElementById('sortCriterion').value.toLowerCase();
    var sortOrder = document.getElementById('sortOrder').value.toLowerCase();
    var doctorBoxes = Array.from(document.querySelectorAll('.doccontainer .doctor-box'));

    // Sort the doctorBoxes array based on the selected criterion and order
    doctorBoxes.sort(function(a, b) {
        var valueA, valueB;
        if (sortCriterion === 'experience') {
            valueA = parseInt(a.querySelector('.experience').textContent);
            valueB = parseInt(b.querySelector('.experience').textContent);
        } else if (sortCriterion === 'price') {
            valueA = parseFloat(a.querySelector('.price').textContent.replace(/[^\d.-]/g, ''));
            valueB = parseFloat(b.querySelector('.price').textContent.replace(/[^\d.-]/g, ''));
        }

        if (sortOrder === 'asc') {
            return valueA - valueB;
        } else {
            return valueB - valueA;
        }
    });

    // Remove all existing doctor boxes from the DOM
    doctorBoxes.forEach(function(doctorBox) {
        doctorBox.parentNode.removeChild(doctorBox);
    });

    // Re-add the sorted doctor boxes to the DOM
    var container = document.querySelector('.doccontainer');
    doctorBoxes.forEach(function(doctorBox) {
        container.appendChild(doctorBox);
    });
}

document.getElementById('sortCriterion').addEventListener('change', handleSorting);
document.getElementById('sortOrder').addEventListener('change', handleSorting);

// Function to open side window
function openSideWindow(doctorName, doctorField) {
    var modal = document.getElementById("modal");
    var modalDocName = modal.querySelector(".modaldocname");
    var modalField = modal.querySelector(".modalfield");

    modalDocName.textContent = doctorName;
    modalField.textContent = "Field: " + doctorField;
    
    modal.style.display = "block";
    setTimeout(function() {
        modal.style.opacity = 1;
        modalDocName.style.opacity = 1;
        modalField.style.opacity = 1;
    }, 10); // Delay for smoother transition
}

// Function to close side window
function closeSideWindow() {
    var modal = document.getElementById("modal");
    var modalDocName = modal.querySelector(".modaldocname");
    var modalField = modal.querySelector(".modalfield");
    
    modal.style.opacity = 0;
    modalDocName.style.opacity = 0;
    modalField.style.opacity = 0;
    
    setTimeout(function() {
        modal.style.display = "none";
    },300);
}

document.querySelector("#modal .close").addEventListener("click", function(event) {
    closeSideWindow();
});

// Function to reset the disabled slots
function resetDisabledSlots() {
    var iframe = document.getElementById('dateChooserFrame');
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    var cells = iframeDoc.querySelectorAll('.cell.py-1');
    cells.forEach(function(cell) {
        cell.parentElement.style.pointerEvents = 'auto';
        cell.parentElement.style.opacity = '1';
        cell.style.backgroundColor = ''; // Reset background color
    });
}

// Function to reset the date input value
function resetDateInput() {
    var iframe = document.getElementById('dateChooserFrame');
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document; 
    var input_date = iframeDoc.querySelector('.datepicker');
    input_date.value = null;
}

// Function to convert date format from dd-mm-yyyy to yyyy-mm-dd
function convertDateFormat(dateString) {
    var parts = dateString.split("-");
    return parts[2] + "-" + parts[1] + "-" + parts[0];
}

// Function to convert time from HH:MM:SS to HH:MMPM format
function formatTimeToAmPm(time) {
    var parts = time.split(':');
    var hour = parseInt(parts[0], 10);
    var minutes = parts[1];
    var ampm = hour >= 12 ? 'PM' : 'AM';
    return (hour < 10 ? '0' + hour : hour) + ':' + minutes + ampm;
}
function convertToTimeObject(time) {
    var parts = time.match(/(\d{2}):(\d{2})(AM|PM)/);
    var hour = parseInt(parts[1], 10);
    var minutes = parseInt(parts[2], 10);
    var ampm = parts[3];
    if (ampm === 'PM' && hour < 12) hour += 12;
    if (ampm === 'AM' && hour === 12) hour = 0;
    return new Date(0, 0, 0, hour, minutes);
}
// Function to disable booked slots in the UI
function disableBookedSlots(bookedSlots) {
    console.log('disableBookedSlots function called');
    var iframe = document.getElementById('dateChooserFrame');
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    var cells = iframeDoc.querySelectorAll('.cell.py-1');
    cells.forEach(function(cell) {
        var cellInnerText = cell.innerText.trim();
        console.log('Comparing cell time:', cellInnerText);
        if (bookedSlots.includes(cellInnerText)) {
            cell.parentElement.style.pointerEvents = 'none';
            cell.parentElement.style.opacity = '0.55';
            cell.style.backgroundColor = 'white';
            console.log('Cell with text ' + cellInnerText + ' disabled');
        }
    });
    console.log('disableBookedSlots function executed successfully');
}

// Function to reset the disabled slots and date input value
function resetDisabledSlotsAndDateInput() {
  resetDisabledSlots(); // Reset disabled slots
  resetDateInput(); // Reset date input value
}

// Initial setup for date picker
document.addEventListener('DOMContentLoaded', function() {
    var datePicker = document.getElementById("dp1");
    if (datePicker) {
        datePicker.addEventListener('change', function(event) {
            var selectedDate = event.target.value;
            bookAppointmentOnDateSelect(selectedDate); // Call function to handle date selection and appointment booking
            resetDisabledSlotsAndDateInput(); // Reset disabled slots and date input value
        });

        var initialSelectedDate = datePicker.value;
        if (initialSelectedDate) {
            var initialFormattedDate = convertDateFormat(initialSelectedDate);
            bookAppointmentOnDateSelect(initialFormattedDate); // Call function to handle initial date selection and appointment booking
            resetDisabledSlotsAndDateInput(); // Reset disabled slots and date input value
        }
    }
});


// Function to handle booking an appointment on date select
function bookAppointmentOnDateSelect(selectedDate) {
    var iframe = document.getElementById('dateChooserFrame');
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    var allCells = iframeDoc.querySelectorAll('.cell.py-1');
    allCells.forEach(function(cell) {
        cell.parentElement.style.pointerEvents = 'auto';
        cell.parentElement.style.opacity = '1';
    });

    var formattedDate = convertDateFormat(selectedDate);
    var modal = document.getElementById("modal");
    var modalDocName = modal.querySelector(".modaldocname");
    var docname = modalDocName.textContent;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/fetch_booked_slots.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    var bookedSlots = JSON.parse(xhr.responseText).map(slot => formatTimeToAmPm(slot));
                    console.log('Booked slots:', bookedSlots);
                    disableBookedSlots(bookedSlots);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    var formData = 'selectedDate=' + encodeURIComponent(formattedDate) + '&docname=' + encodeURIComponent(docname);
    xhr.send(formData);
}

// Function to convert date format from dd-mm-yyyy to yyyy-mm-dd
function convertDateFormat(dateString) {
    var parts = dateString.split("-");
    return parts[2] + "-" + parts[1] + "-" + parts[0];
}


// Function to setup time slot selection
function setupTimeSlotSelection() {
    var selectedDiv = null;
  
    var iframe = document.getElementById('dateChooserFrame');
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
   
    var divs = iframeDoc.querySelectorAll('.cell.py-1');
    for (var i = 0; i < divs.length; i++) {
      divs[i].addEventListener("click", function() {
        if (selectedDiv !== null) {
          selectedDiv.classList.remove("select");
        }
        this.classList.add("select");
        selectedDiv = this;
      });
    }
  
    var input_date = iframeDoc.querySelector('.datepicker');
    var submitButton = document.getElementById("submitButton");
  
    submitButton.addEventListener("click", function() {
      if (isSessionActive()) {
        var selectedDate = input_date.value;
        
        if (selectedDate.trim() === "") {
          alert("Please select a date for the appointment.");
        } else {
          if (selectedDiv !== null) {
            var selectedSlot = selectedDiv.textContent;
            var modal = document.getElementById("modal");
            var modalDocName = modal.querySelector(".modaldocname");
            var docname = modalDocName.textContent;
            
            var xhr = new XMLHttpRequest();
            var phpFile = "../php/confirm_appointment.php";
            var data = new FormData();
            data.append('docname', docname);
            data.append('selectedDate', selectedDate);
            data.append('selectedSlot', selectedSlot);
            xhr.open("POST", phpFile, true);
            xhr.onload = function() {
              if (xhr.status === 200) {
                console.log(xhr.responseText);
                alert("Appointment successfully booked.");
                selectedDiv.classList.remove("select");
                selectedDiv.parentElement.style.pointerEvents = 'none';
                selectedDiv.parentElement.style.opacity = '0.55';
                selectedDiv.style.backgroundColor = 'white';
              } else {
                console.error("Request failed:" + xhr.status);
                alert("Error booking appointment. Please try again later.");
              }
            };
            xhr.onerror = function() {
                console.error("Request failed.");
                alert("Error booking appointment. Please try again later.");
            };
            xhr.send(data);
          } else {
            alert("Please select a time slot first.");
          }
        }
      } else {
        setTimeout(function() {
            var modal = document.getElementById("sessionModal");
            modal.style.display = "block";
            var closeBtn = modal.querySelector(".clogin");
            closeBtn.onclick = function() {
                modal.style.display = "none";
            };
            closeSideWindow();
        }, 100); // 100 milliseconds delay
      }
    });
}

function isSessionActive() {
    return "<?php echo isset($_SESSION['mail-id']); ?>" === "1";
}

window.onload = setupTimeSlotSelection;
document.addEventListener('DOMContentLoaded', function() {
    var datePicker = document.getElementById("dp1");
    if (datePicker) {
        datePicker.addEventListener('change', function(event) {
            var selectedDate = event.target.value;
            resetDisabledSlots(); // Call resetDisabledSlots function whenever the date changes
            bookAppointmentOnDateSelect(selectedDate); // Call function to handle date selection and appointment booking
        });

        var initialSelectedDate = datePicker.value;
        if (initialSelectedDate) {
            var initialFormattedDate = convertDateFormat(initialSelectedDate);
            resetDisabledSlots(); // Call resetDisabledSlots function for the initial date
            bookAppointmentOnDateSelect(initialFormattedDate); // Call function to handle initial date selection and appointment booking
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var datePicker = document.getElementById("dp1");
    if (datePicker) {
        datePicker.addEventListener('change', function(event) {
            var selectedDate = event.target.value;
            bookAppointmentOnDateSelect(selectedDate); // Call function to handle date selection and appointment booking
        });

        var initialSelectedDate = datePicker.value;
        if (initialSelectedDate) {
            var initialFormattedDate = convertDateFormat(initialSelectedDate);
            bookAppointmentOnDateSelect(initialFormattedDate); // Call function to handle initial date selection and appointment booking
        }
    }
});
</script>

</body>
</html> 