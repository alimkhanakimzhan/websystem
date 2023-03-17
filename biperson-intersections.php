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
    <div class="wrapper" style="">
      <div class="container rounded bg-white mt-5 mb-5">


<!-- search form start-->
        <form class="container" action="biperson-intersections.php" method="GET">
          <div class="row d-flex justify-content-center">
            <div class="col-md-10">
              <div class="card p-3  py-4">
                <h5>Поиск гражданина:</h5>
                <div class="row g-3 mt-2">
                  <div class="col-md-4">
                    <input name="search-field1" type="text" class="form-control" placeholder="ИИН 1-го человека">
                  </div>
                  <div class="col-md-4">
                    <input name="search-field2" type="text" class="form-control" placeholder="ИИН 2-го человека">
                  </div>
                  <div class="col-md-3">
                    <button class="btn btn-secondary btn-block">Найти</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
<!-- search form end-->
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-9">
              <?php
              // function to retrieve organization name given an organization id
              function get_organization_name($db, $org_id) {
                  $sql = "SELECT Name FROM organizations_list WHERE id = $org_id";
                  $result = mysqli_query($db, $sql);
                  $row = mysqli_fetch_array($result);
                  return $row['Name'];
              }

              $person_iin_1 = isset($_GET['search-field1']) ? $_GET['search-field1'] : '';
              $person_iin_2 = isset($_GET['search-field2']) ? $_GET['search-field2'] : '';

              if(!empty($person_iin_1) AND !empty($person_iin_2)){
                // retrieve information for person 1
                $sql = "SELECT FirstName, LastName, id
                        FROM person
                        WHERE IIN = $person_iin_1";
                $result = mysqli_query($db, $sql);

                // check if query was successful
                if ($result) {
                  $person_1 = mysqli_fetch_assoc($result);
                  $person_id_1 = $person_1['id'];
                } else {
                  die("Error retrieving information for person 1: " . mysqli_error($db));
                }

                // retrieve information for person 2
                $sql = "SELECT FirstName, LastName, id
                        FROM person
                        WHERE IIN = $person_iin_2";
                $result = mysqli_query($db, $sql);

                // check if query was successful
                if ($result) {
                  $person_2 = mysqli_fetch_assoc($result);
                  $person_id_2 = $person_2['id'];;
                } else {
                  die("Error retrieving information for person 2: " . mysqli_error($db));
                }

                // retrieve relatives for person 1
                $sql = "SELECT person_relative_id, person_id, relationship_type, relative_id
                        FROM relatives
                        WHERE person_id = $person_id_1";
                $result = mysqli_query($db, $sql);


                // $person_id_1 = isset($_GET['search-field1']) ? $_GET['search-field1'] : '';
                // $person_id_2 = isset($_GET['search-field2']) ? $_GET['search-field2'] : '';
                // check if query was successful
                if ($result) {
                  $relatives_1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
                } else {
                  die("Error retrieving relatives for person 1: " . mysqli_error($db));
                }

                // retrieve relatives for person 2
                $sql = "SELECT person_relative_id, person_id, relationship_type, relative_id
                        FROM relatives
                        WHERE person_id = $person_id_2";
                $result = mysqli_query($db, $sql);

                // check if query was successful
                if ($result) {
                  $relatives_2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
                } else {
                  die("Error retrieving relatives for person 2: " . mysqli_error($db));
                }

                // find common relatives between person 1 and person 2
                $common_relatives = array();
                $unique_relatives = array();
                foreach ($relatives_1 as $relative_1) {
                  foreach ($relatives_2 as $relative_2) {
                      if ($relative_1['relative_id'] != 0 && $relative_1['relative_id'] == $relative_2['relative_id'] && !in_array($relative_1['relative_id'], $unique_relatives)) {
                          $common_relatives[] = $relative_1;
                          $unique_relatives[] = $relative_1['relative_id'];
                      }
                  }
                }


                if (empty($common_relatives)) {
                    echo "Не найдено родственных связей<br>";
                } else {
                    echo "Общие родственные связи:<br>";
                    foreach ($common_relatives as $relative) {
                        $sql = 'SELECT * FROM person WHERE id = '.$relative["relative_id"].'';
                        $result = mysqli_query($db, $sql);
                        if (!$result) {
                            echo "Error: " . mysqli_error($db);
                            exit;
                        }
                        $row = mysqli_fetch_array($result);
                        echo '<a href="person-single.php?id='.$relative["relative_id"].'">'.$row['LastName'].' '.$row['FirstName'].' </a>' ;
                    }
                    echo "<br>";
                }

                // retrieve job history for person 1
                $sql = "SELECT time_start_position, time_end_position, person_id, organization_ID
                        FROM Job_history
                        WHERE person_id = $person_id_1";
                $result = mysqli_query($db, $sql);
                $person_1_orgs = array();
                while ($row = mysqli_fetch_array($result)) {
                    $org_id = $row['organization_ID'];
                    // retrieve organization name
                    $org_name = get_organization_name($db, $org_id);
                    $person_1_orgs[] = $org_name;
                }

                // retrieve job history for person 2
                $sql = "SELECT time_start_position, time_end_position, person_id, organization_ID
                        FROM Job_history
                        WHERE person_id = $person_id_2";
                $result = mysqli_query($db, $sql);
                $person_2_orgs = array();
                while ($row = mysqli_fetch_array($result)) {
                    $org_id = $row['organization_ID'];
                    // retrieve organization name
                    $org_name = get_organization_name($db, $org_id);
                    $person_2_orgs[] = $org_name;
                }

                // find common organizations
                $common_organization_names = array_unique(array_intersect($person_1_orgs, $person_2_orgs));

                if (empty($common_organization_names)) {
                    echo "Не найдено по организации<br>";
                } else {
                    echo "Место организации (пересечения):<br>";
                    foreach ($common_organization_names as $org_name) {
                        echo $org_name . "<br>";
                    }
                }
              }
              else {
                echo "Заполните все поля с дейсвительными данными!";
              }
               ?>
              </div>
            </div>
          </div>



        </div>
      </div>
        <?php
        $page = "biperson_intersections_page";
        require_once(HOME_DIR.'/include/navmenu.php');
        ?>
      </body>
    </html>
