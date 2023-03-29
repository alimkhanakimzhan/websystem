<?php

require_once "config.php";
require_once "session.php";


$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // validate if email is empty
    if (empty($email)) {
        $error .= '<p class="error">Please enter email.</p>';
    }

    // validate if password is empty
    if (empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if (empty($error)) {

      if($query = $db->prepare("SELECT * FROM users WHERE email = '$email'")) {
          // $email = addslashes($email);
          // $query->bind_param("s", $email);
        	$query->execute();
          $result = $query->get_result();
          if ($row = $result->fetch_assoc()) {
                  if (! empty($row)) {
                      if (password_verify($password, $row["password"])) {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user"] = $row;
                        $_SESSION["role"] = $row['role'];
                        $_SESSION["nickname"] = $row['nickname'];

                        // Redirect the user to welcome page
                        if ($_SESSION['role'] == 1){
                          header("location: admin/index.php");
                        }
                        else {
                          header("location: index.php");
                        }
                        exit;
                      }
                      else {
                         $password = password_hash($password, PASSWORD_BCRYPT);
                         $error .= '<p class="error">The password is not valid.'.$password.' Password: '.$row["password"].'</p>';
                     }
                  }
              }
              else {
                 $error .= '<p class="error">No User exist with that email address: <b>'.$email.'</b> </p>';
              }


        $query->close();
    }
    // Close connection
    mysqli_close($db);
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link
          href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap"
          rel="stylesheet"
        />
        <script src="https://kit.fontawesome.com/a81368914c.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>
    <body>
      <div class="container">
        <div class="img"></div>
        <div class="login-content">
                    <form action="" method="post">
                        <h2 class="title">Web-System</h2>
                        <div class="input-div one">
                          <div class="i">
                            <i class="fas fa-user"></i>
                          </div>
                          <div class="div">
                            <h5>Email</h5>
                            <input type="text" name="email" class="input" />
                          </div>
                        </div>
                        <div class="input-div pass">
                          <div class="i">
                            <i class="fas fa-lock"></i>
                          </div>
                          <div class="div">
                            <h5>Пароль</h5>
                            <input type="password" name="password" class="input" />
                          </div>
                        </div>
                        <a href="register.php">Регистрация?</a>
                        <input type="submit" name="submit" class="btn" value="Submit" />
                        <?php echo $error; ?>
                    </form>
                  </div>
                </div>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
