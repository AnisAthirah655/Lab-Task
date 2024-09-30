<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="includes.css" />
    <title>Edit Record</title>
</head>

<body>

<?php include("header.php"); // Database connection should be included here ?>

<h2>Edit a Record</h2>

<?php
// Ensure a valid ID is passed through GET or POST
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "<p class='error'>This page has been accessed in error.</p>";
    exit();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Validate First Name
    if (empty($_POST['FirstName_P'])) {
        $errors[] = 'You forgot to enter the First Name.';
    } else {
        $fn = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
    }

    // Validate Last Name
    if (empty($_POST['LastName_P'])) {
        $errors[] = 'You forgot to enter the Last Name.';
    } else {
        $ln = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
    }

    // Validate Insurance Number
    if (empty($_POST['Insurance_Number'])) {
        $errors[] = 'You forgot to enter the Insurance Number.';
    } else {
        $in = mysqli_real_escape_string($connect, trim($_POST['Insurance_Number']));
    }

    // Validate Diagnosis
    if (empty($_POST['Diagnose'])) {
        $errors[] = 'You forgot to enter the Diagnosis.';
    } else {
        $d = mysqli_real_escape_string($connect, trim($_POST['Diagnose']));
    }

    // If no errors, proceed with the update
    if (empty($errors)) {
        // Ensure that the Insurance Number is unique except for the current record
        $q = "SELECT ID_P FROM pesakit WHERE Insurance_Number='$in' AND ID_P != $id";
        $result = mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 0) {
            // Update the record
            $q = "UPDATE pesakit 
                  SET FirstName_P='$fn', LastName_P='$ln', Insurance_Number='$in', Diagnose='$d' 
                  WHERE ID_P=$id LIMIT 1";

            $result = mysqli_query($connect, $q);

            if (mysqli_affected_rows($connect) == 1) {
                echo "<h3>The user has been successfully edited.</h3>";
            } else {
                echo "<p class='error'>The user could not be edited due to a system error. We apologize for any inconvenience.</p>";
                echo "<p>" . mysqli_error($connect) . "<br/>Query: $q </p>";
            }
        } else {
            echo '<p class="error">The Insurance Number has already been registered.</p>';
        }
    } else {
        // Display the errors
        echo '<p class="error">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p>';
    }
}

// Retrieve the current user's information
$q = "SELECT FirstName_P, LastName_P, Insurance_Number, Diagnose FROM pesakit WHERE ID_P=$id";
$result = mysqli_query($connect, $q);

if (mysqli_num_rows($result) == 1) {
    // Fetch the row
    $row = mysqli_fetch_array($result, MYSQLI_NUM);

    // Display the form with the current information
    echo '<form action="edit_pesakit.php" method="post">';
    echo '<p><label class="label" for="FirstName_P">First Name:</label>
          <input id="FirstName_P" type="text" name="FirstName_P" size="30" maxlength="30" value="' . $row[0] . '"></p>';
    echo '<p><label class="label" for="LastName_P">Last Name:</label>
          <input id="LastName_P" type="text" name="LastName_P" size="30" maxlength="30" value="' . $row[1] . '"></p>';
    echo '<p><label class="label" for="Insurance_Number">Insurance Number:</label>
          <input id="Insurance_Number" type="text" name="Insurance_Number" size="30" maxlength="30" value="' . $row[2] . '"></p>';
    echo '<p><label class="label" for="Diagnose">Diagnosis:</label>
          <input id="Diagnose" type="text" name="Diagnose" size="30" maxlength="30" value="' . $row[3] . '"></p>';
    echo '<br><input id="submit" type="submit" name="submit" value="Edit">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '</form>';
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}

// Close the database connection
mysqli_close($connect);
?>

</body>
</html>
