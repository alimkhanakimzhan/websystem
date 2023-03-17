<?php
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

?>
<html>
  <?php require_once(HOME_DIR.'/include/header.php') ?>
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
    require_once(HOME_DIR.'/include/navmenu.php');
    ?>

  </body>
</html>
