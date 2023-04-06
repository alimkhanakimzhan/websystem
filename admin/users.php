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

?>
<html>
  <?php require_once('include/header.php') ?>
  <body>
    <div class="wrapper">
      <div class="container rounded mt-5 mb-5">
        <a href=users_adduser.php> <span>+ Add new user</span> </a>
        <?php
        $query = $db->prepare("SELECT * FROM `users`");

                $query->execute();
                $result = $query->get_result();
                echo '

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th>user_id</th>
                        <th>nickname</th>
                        <th>email</th>
                        <th>role</th>
                      </tr>
                    </thead>
                    <tbody>
                ';
                  while ($row = $result->fetch_assoc()) {
                      $id = $row["id"];
                      $nickname = $row["nickname"];
                      $email = $row["email"];
                      $role = $row["role"];

                      echo '

                      <tr class="alert" role="alert">
                        <td class="">
                          <span>'.$id.'</span>
                        </td>
                        <td class="">
                          <span>'.$nickname.'</span> </a>
                        </td>
                        <td class="">
                          <span>'.$email.'</span>
                        </td>
                        <td class="">
                          <span>'.$role.'</span>
                        </td>
                        <td class="">
                          <a href=edit-user.php?id='.$id.'> <span>Edit</span> </a>
                        </td>
                      </tr>';
                  }
                  echo '
                  </tbody>
                  </table>

                  ';
              /*freeresultset*/
              $result->free();

          ?>
        </table>


      </div>
    </div>

    <?php
    $page = "users_page";
    require_once('include/navmenu.php');
    ?>

  </body>
</html>
