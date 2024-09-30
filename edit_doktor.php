<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit User Record</title>
</head>
<body>

<?php include("header.php"); ?>

<h2> Edit a record </h2>

<?php
// Ensure a valid user ID is provided either through GET or POST
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

    // Validate the FirstName field
    if (empty($_POST['FirstName'])) {
        $errors[] = 'You forgot to enter the First Name.';
    } else {
        $fn = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
    }

    // Validate the LastName field
    if (empty($_POST['LastName'])) {
        $errors[] = 'You forgot to enter the Last Name.';
    } else {
        $ln = mysqli_real_escape_string($connect, trim($_POST['LastName']));
    }

    // Validate the Specialization field
    if (empty($_POST['Specialization'])) {
        $errors[] = 'You forgot to enter the Specialization.';
    } else {
        $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
    }

    // Validate the Password field
    if (empty($_POST['Password'])) {
        $errors[] = 'You forgot to enter the Password.';
    } else {
        $p = mysqli_real_escape_string($connect, trim($_POST['Password']));
    }

    // Check if there were no validation errors
    if (empty($errors)) {
        // Check if the specialization and ID combination already exists
        $q = "SELECT ID FROM doktor WHERE Specialization = '$s' AND ID = $id";
        $result = mysqli_query($connect, $q);
        
        if (mysqli_num_rows($result) == 0) {
            // Update the user record
            $q = "UPDATE doktor SET FirstName='$fn', LastName='$ln', Specialization='$s', Password='$p' WHERE ID=$id LIMIT 1";
            $result = mysqli_query($connect, $q);
            
            if (mysqli_affected_rows($connect) == 1) {
                echo "<h3>The user has been edited.</h3>";
            } else {
                echo "<p class='error'>The user has not been edited due to a system error. We apologize for any inconvenience.</p>";
                echo "<p>" . mysqli_error($connect) . "<br/>Query: $q </p>";
            }
        } else {
            echo '<p class="error">The ID has already been registered</p>';
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

// Retrieve the user's current information
$q = "SELECT FirstName, LastName, Specialization, Password FROM doktor WHERE ID=$id";
$result = mysqli_query($connect, $q);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    
    // Display the form with the current data pre-filled
    echo '<form action="edit_doktor.php" method="post">';
    echo '<p><label class="label" for="FirstName">First Name:</label>
          <input id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="' . $row[0] . '"></p>';
    echo '<p><label class="label" for="LastName">Last Name:</label>
          <input id="LastName" type="text" name="LastName" size="30" maxlength="30" value="' . $row[1] . '"></p>';
    echo '<p><label class="label" for="Specialization">Specialization:</label>
          <input id="Specialization" type="text" name="Specialization" size="30" maxlength="30" value="' . $row[2] . '"></p>';
    echo '<p><label class="label" for="Password">Password:</label>
          <input id="Password" type="text" name="Password" size="30" maxlength="30" value="' . $row[3] . '"></p>';
    echo '<br><input id="submit" type="submit" name="submit" value="Edit">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '</form>';
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($connect);
?>

</body>
</html>
