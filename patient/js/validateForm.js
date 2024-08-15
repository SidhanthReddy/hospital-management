function validateForm() {
    var fname = document.forms["register"]["fname"].value;
    var lname = document.forms["register"]["lname"].value;
    var gender = document.forms["register"]["gender"].value;
    var date1 = document.forms["register"]["date1"].value;
    var email1 = document.forms["register"]["email1"].value;
    var newpass = document.forms["register"]["newpass"].value;
    var repass = document.forms["register"]["repass"].value;
    var phoneno = document.forms["register"]["phoneno"].value;

    if (fname == "") {
        alert("First name must be filled out");
        return false;
    }
    if (lname == "") {
        alert("Last name must be filled out");
        return false;
    }
    if (gender == "") {
        alert("Gender must be selected");
        return false;
    }
    if (date1 == "") {
        alert("Birth date must be filled out");
        return false;
    }
    
    var currentDate = new Date();
    var birthDate = new Date(date1);
    var age = currentDate.getFullYear() - birthDate.getFullYear();
    
    if (age < 18 || age > 100) {
        alert("You must be between 18 and 100 years old to register");
        return false;
    }

    // Check if the selected date is in the future
    if (birthDate > currentDate) {
        alert("Please select a birth date in the past");
        return false;
    }

    if (email1 == "") {
        alert("Email must be filled out");
        return false;
    }
    if (newpass == "") {
        alert("Password must be filled out");
        return false;
    }
    if (newpass != repass) {
        alert("Passwords do not match");
        return false;
    }
    if (phoneno == "") {
        alert("Phone number must be filled out");
        return false;
    }

    return true;
}
