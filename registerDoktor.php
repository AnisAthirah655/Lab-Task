<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Klinik Ajwa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php
// Call the file to connect to the server
include ("header.php");

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array(); // Initialize an error array

    // Check for First Name
    if (empty($_POST['FirstName'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
    }

    // Check for Last Name
    if (empty($_POST['LastName'])) {
        $errors[] = 'You forgot to enter your last name.';
    } else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
    }

    // Check for Specialization
    if (empty($_POST['Specialization'])) {
        $errors[] = 'You forgot to enter your specialization.';
    } else {
        $i = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
    }

    // Check for Password
    if (empty($_POST['Password'])) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $d = mysqli_real_escape_string($connect, trim($_POST['Password']));
    }

    // If no errors, insert the record into the database
    if (empty($errors)) {
        // Make the query
        $q = "INSERT INTO doktor (ID, FirstName, LastName, Specialization, Password)
              VALUES (NULL, '$n', '$l', '$i', '$d')";

        $result = @mysqli_query($connect, $q); // Run the query

        if ($result) { // If it runs successfully
            echo '<h1>Thank you! Registration successful.</h1>';
            exit();
        } else { // If there is an error
            echo '<h1>System error</h1>';
            echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        }
    } else { // Display errors
        echo '<h1>Error!</h1>';
        echo '<p>The following errors occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p>';
    }

    // Close the database connection
    mysqli_close($connect);
}
?>

<h2>Register</h2>
<h4>* required field</h4>

<form action="registerDoktor.php" method="post">
    <p><label class="label" for="FirstName">First Name: *</label>
    <input id="FirstName" type="text" name="FirstName" size="30" maxlength="150"
           value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>" /></p>

    <p><label class="label" for="LastName">Last Name: *</label>
    <input id="LastName" type="text" name="LastName" size="30" maxlength="60"
           value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>" /></p>

    <p><label class="label" for="Specialization">Specialization: *</label>
    <input id="Specialization" type="text" name="Specialization" size="30" maxlength="150"
           value="<?php if (isset($_POST['Specialization'])) echo $_POST['Specialization']; ?>" /></p>

    <p><label class="label" for="Password">Password: *</label>
    <input id="Password" type="password" name="Password" size="12" maxlength="12"
           value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" /></p>

    <p><input id="submit" type="submit" name="submit" value="Register" /> &nbsp;&nbsp;
    <input id="reset" type="reset" name="reset" value="Clear All" /></p>
</form>

<p><br /><br /><br /></p>

</body>
</html>
