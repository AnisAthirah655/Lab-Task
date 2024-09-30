<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
    <title>Klinik Ajwa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>

<body>

<?php
// Call the file to connect to server
include("header.php");?>


<?php
// This query inserts a record in the 'pesakit' table
// Has the form been submitted?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array(); // Initialize an error array

    // Check for First Name
    if (empty($_POST['FirstName_P'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
    }

    // Check for Last Name
    if (empty($_POST['LastName_P'])) {
        $errors[] = 'You forgot to enter your last name.';
    } 
    else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
    }

    // Check for Insurance Number
    if (empty($_POST['Insurance_Number'])) {
        $errors[] = 'You forgot to enter your insurance number.';
    } 
    else {
        $i = mysqli_real_escape_string($connect, trim($_POST['Insurance_Number']));
    }

    // Check for Diagnosis
    if (empty($_POST['Diagnose'])) {
        $errors[] = 'You forgot to enter your diagnosis.';
    } 
    else {
        $d = mysqli_real_escape_string($connect, trim($_POST['Diagnose']));
    }

    // If there are no errors, register the patient in the database
    // Make the query:
        $q = "INSERT INTO pesakit (ID_P, FirstName_P, LastName_P, Insurance_Number, Diagnose)
              VALUES (NULL, '$n', '$l', '$i', '$d')";
        $result = @mysqli_query($connect, $q); // Run the query
        if ($result) { // If it runs
        echo '<h1>Thank you for registering!</h1>';
        exit();
        } else { // If it didn't run
        //message
        echo '<h1>System error</h1>';

        //debugging message
        echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        } //end of it (result)
        mysqli_close($connect);
        exit();
    
} //End of the main conditional

?>

<h2>Register</h2>
<h4>* Required field</h4>
<form action="register.php" method="post">

    <p><label class="label" for="FirstName_P">First Name: *</label>
    <input id="FirstName_P" type="text" name="FirstName_P" size="30" maxlength="150"
    value="<?php if (isset($_POST['FirstName_P'])) echo $_POST['FirstName_P']; ?>" /></p>

    <p><label class="label" for="LastName_P">Last Name: *</label>
    <input id="LastName_P" type="text" name="LastName_P" size="30" maxlength="60"
    value="<?php if (isset($_POST['LastName_P'])) echo $_POST['LastName_P']; ?>" /></p>

    <p><label class="label" for="Insurance_Number">Insurance Number: *</label>
    <input id="Insurance_Number" type="text" name="Insurance_Number" size="30" maxlength="12"
    value="<?php if (isset($_POST['Insurance_Number'])) echo $_POST['Insurance_Number']; ?>" /></p>

    <p><label class="label" for="Diagnose">Diagnosis: </label></p>
    <textarea name="Diagnose" rows="5" cols="40"><?php if (isset($_POST['Diagnose'])) echo $_POST['Diagnose']; ?></textarea>

    <p><input id="submit" type="submit" name="submit" value="Register" /> &nbsp;&nbsp;
    <input id="reset" type="reset" name="reset" value="Clear All" /></p>
</p>
</form>
<p>
<br />
<br />
<br />
</body>
</html>
