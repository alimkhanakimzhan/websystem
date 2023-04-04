<?php
require_once ('../config.php');
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
else {
  if ($_SESSION['role'] == 0){
    header("location: ../index.php");
  }
}

if(!isset($_GET['id'])) {
  header("location: person.php");
}
else {
    $user_id = $_GET['id'];
    if($query = $db->prepare("SELECT * FROM `users` WHERE id = $user_id")) {
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();
      $nickname = $row["nickname"];
      $email = $row["email"];
      $role = $row["role"];
      }
    $query->close();




      $error = '';
      $success = '';

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

          $newnickname = trim($_POST['nickname']);
          $newemail = trim($_POST['email']);
          $newpassword = trim($_POST['password']);
          $confirm_password = trim($_POST["confirm_password"]);
          $newpassword_hash = password_hash($newpassword, PASSWORD_BCRYPT);

          if($query = $db->prepare("SELECT * FROM `users` WHERE email = ? OR nickname = ?")) {
                    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
            	$query->bind_param("ss", $newemail, $newnickname);
            	$query->execute();
            	// Store the result so we can check if the account exists in the database.
                  if ($query->num_rows > 0) {
                    $result = $query->get_result();
                    if ($row = $result->fetch_assoc()) {
                      if (! empty($row)) {
                            $selectedUserId = $row['id'];
                            $selectedNickname = $row['nickname'];
                            $selectedEmail = $row['email'];

                            if($selectedUserId != $user_id){
                              $error .= '<p class="error" style="color:coral">A user with these email or nickname is already registered!</p>';
                            }
                          }
                        }

                  } else {
                        // Validate password
                        if (strlen($newpassword ) < 6) {
                            $error .= '<p class="error" style="color:coral">Password must have atleast 6 characters.</p>';
                        }

                        // Validate confirm password
                        if (empty($confirm_password)) {
                            $error .= '<p class="error" style="color:coral">Please enter confirm password.</p>';
                        } else {
                            if (empty($error) && ($newpassword != $confirm_password)) {
                                $error .= '<p class="error" style="color:coral">Password did not match.</p>';
                            }
                        }
                        if (empty($error) ) {
                          $query = "UPDATE `users` SET `nickname`=?, `password`=?, `email`=? WHERE id=?";
                          $stmt = $db->prepare($query);

                          if (!$stmt) {
                              die('Query preparation failed: ' . $db->error);
                          }

                          $stmt->bind_param('sssi', $newnickname, $newpassword_hash, $newemail, $user_id);
                          $result = $stmt->execute();

                          if ($result) {
                              $success .= '<p class="success" style="color:green">Updating user was successful!</p>';
                          } else {
                              $error .= '<p class="error" style="color:coral">Something went wrong!</p>';
                          }

                          $stmt->close();
                        }
                    }
            }
     }





  }




?>

<html>
  <?php require_once('include/header.php') ?>
  <body>
    <div class="wrapper">
      <div class="container rounded mt-5 mb-5">

        <form action="" method="post">
            <h2 class="title">Edit a User</h2>
            <div class="input-div one">
              <div class="div">
                <h5>Nickname</h5>
                <input type="text" name="nickname" class="input" value="<?php echo $nickname; ?>"/>
              </div>
            </div>
            <div class="input-div">
              <div class="div">
                <h5>Email</h5>
                <input type="email" name="email" class="input" value="<?php echo $email; ?>"/>
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
            <input type="submit" name="submit" class="btn" value="Update" />
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
