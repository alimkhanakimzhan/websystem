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
    header("location: ../index.php");
  }
}


$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $nickname = trim($_POST['nickname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);


    // $selectQuery = "SELECT * FROM `users` WHERE email = ? OR nickname = ?";

    if($query = $db->prepare("SELECT * FROM `users` WHERE email = ? OR nickname = ?")) {
              // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
      	$query->bind_param("ss", $email, $nickname);
      	$query->execute();
      	// Store the result so we can check if the account exists in the database.
      	$query->store_result();
              if ($query->num_rows > 0) {
                  $error .= '<p class="error" style="color:coral">This user is already registered!</p>';
              } else {
                  // Validate password
                  if (strlen($password ) < 6) {
                      $error .= '<p class="error" style="color:coral">Password must have atleast 6 characters.</p>';
                  }

                  // Validate confirm password
                  if (empty($confirm_password)) {
                      $error .= '<p class="error" style="color:coral">Please enter confirm password.</p>';
                  } else {
                      if (empty($error) && ($password != $confirm_password)) {
                          $error .= '<p class="error" style="color:coral">Password did not match.</p>';
                      }
                  }
                  if (empty($error) ) {
                      $insertQuery = $db->prepare("INSERT INTO users (nickname, email, password) VALUES (?, ?, ?);");
                      $insertQuery->bind_param("sss", $nickname, $email, $password_hash);
                      $result = $insertQuery->execute();
                      if ($result) {
                          $success .= '<p class="success" style="color:green">Adding new user was successful!</p>';
                      } else {
                          $error .= '<p class="error" style="color:coral">Something went wrong!</p>';
                      }
                  }
              }
      }
    $query->close();
    // Close DB connection
    mysqli_close($db);
}
?>

<html>
  <?php require_once('include/header.php') ?>
  <body>
    <div class="wrapper">
      <div class="container rounded mt-5 mb-5">

        <form action="" method="post">
            <h2 class="title">Add new User</h2>
            <div class="input-div one">
              <div class="div">
                <h5>Nickname</h5>
                <input type="text" name="nickname" class="input" />
              </div>
            </div>
            <div class="input-div">
              <div class="div">
                <h5>Email</h5>
                <input type="email" name="email" class="input" />
              </div>
            </div>
            <div class="input-div">
              <div class="div">
                <h5>Пароль</h5>
                <input type="password" name="password" class="input" />
              </div>
            </div>
            <div class="input-div">
              <div class="div">
                <h5>Пароль</h5>
                <input type="password" name="confirm_password" class="input" />
              </div>
            </div>
            <input type="submit" name="submit" class="btn" value="Submit" />
            <?php echo $success; ?>
            <?php echo $error; ?>
        </form>

      </div>
    </div>

    <?php
    $page = "users_page";
    require_once('include/navmenu.php');
    ?>

  </body>
</html>
