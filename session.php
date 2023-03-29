<?php
// Start the session
session_start();

// if the user is already logged in then redirect user to welcome page
if (isset($_SESSION["userid"]) && $_SESSION["userid"] === true) {
    if ($_SESSION['role'] == 1){
      header("location: admin/index.php");
    }
    else {
      header("location: index.php");
    }
    exit;
}
?>
