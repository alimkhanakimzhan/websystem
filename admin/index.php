<?php
require_once ('../config.php');
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else {
  if ($_SESSION['role'] == 0){
    header("location: BASE_DIR./index.php");
  }
}

?>
<html>
  <?php require_once('include/header.php') ?>
  <body>
    <div class="wrapper">
      <div class="container rounded mt-5 mb-5">
        <p class="text-center">
          Добро Пожаловать, <u><?php echo $_SESSION["nickname"];?></u>!
        </p>
        WebSystem v.2.0 by alimkh_n
      </div>
    </div>

    <?php
    $page = "index_page";
    require_once('include/navmenu.php');
    ?>

  </body>
</html>
