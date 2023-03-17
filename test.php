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
        <form class="container" action="test.php" method="GET">
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


              // Function to retrieve information about a person given their IIN
              function getPerson($db, $IIN) {
                  $query = "SELECT * FROM person WHERE IIN = '$IIN'";
                  $result = mysqli_query($db, $query);
                  if (mysqli_num_rows($result) > 0) {
                      return mysqli_fetch_assoc($result);
                  } else {
                      return null;
                  }
              }



              function getPersonByID($db, $id) {
                  $query = "SELECT * FROM person WHERE id = '$id'";
                  $result = mysqli_query($db, $query);
                  if (mysqli_num_rows($result) > 0) {
                      return mysqli_fetch_assoc($result);
                  } else {
                      return null;
                  }
              }

              // Function to retrieve a list of relatives for a given person
              function getRelatives($db, $person_id) {
                  $relatives = array();
                  $query = "SELECT * FROM relatives WHERE person_id = '$person_id'";
                  $result = mysqli_query($db, $query);
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $relatives[] = $row;
                      }
                  }
                  return $relatives;
              }

              // Function to retrieve a list of job histories for a given person
              function getJobHistories($db, $person_id) {
                  $job_histories = array();
                  $query = "SELECT * FROM job_history WHERE person_id = '$person_id'";
                  $result = mysqli_query($db, $query);
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $job_histories[] = $row;
                      }
                  }
                  return $job_histories;
              }

              // Function to compare two people's job histories
              function compareJobHistories($person1_id, $person2_id) {
                  global $db;
                  if(($person1_id!=0 OR $person2_id!=0) AND ($person1_id != $person2_id)){
                    $person1_histories = getJobHistories($db, $person1_id);
                    $person2_histories = getJobHistories($db, $person2_id);
                    foreach ($person1_histories as $history1) {
                        foreach ($person2_histories as $history2) {
                            if ($history1['organization_ID'] == $history2['organization_ID']) {
                                return true;
                            }
                        }
                    }
                  }
                  return false;
              }


              // Function to find all relations between two people
              function findRelations($db, $person1_id, $person2_id) {
                  $person1_relatives = getRelatives($db, $person1_id);
                  $person2_relatives = getRelatives($db, $person2_id);
                  $person1 = getPersonByID($db, $person1_id);
                  $person2 = getPersonByID($db, $person2_id);

                  if (compareJobHistories($person1_id, $person2_id)) {
                      echo 'Прямые карьерные пересечения найдены у '.$person1['FirstName'].' '.$person1['LastName'].' and '.$person2['FirstName'].' '.$person2['LastName'].'';
                      echo '<br>';
                  }
                  foreach ($person1_relatives as $relative1) {
                      if (compareJobHistories($relative1['relative_id'], $person2_id)) {
                          echo 'Карьерные пересечения найдены у '.$relative1['full_name'].' (Родственник '.$person1['FirstName'].' '.$person1['LastName'].') and '.$person2['FirstName'].' '.$person2['LastName'].'';
                          echo '<br>';
                      }
                  }
                  foreach ($person2_relatives as $relative2) {
                      if (compareJobHistories($person1_id, $relative2['relative_id'])) {
                          echo 'Карьерные пересечения найдены у '.$person1['FirstName'].' '.$person1['LastName'].' and '.$relative1['full_name'].' (Родственник '.$person2['FirstName'].' '.$person2['LastName'].')';
                          echo '<br>';
                      }
                  }


                  foreach ($person1_relatives as $relative1) {
                    foreach ($person2_relatives as $relative2) {
                        if ($relative1['full_name'] == $relative2['full_name']) {
                            echo "Общие родственные свзязи с: " . $relative1['full_name'] . "<br>";
                        }
                    }
                  }

              }




              $IIN1 = isset($_GET['search-field1']) ? $_GET['search-field1'] : '';
              $IIN2 = isset($_GET['search-field2']) ? $_GET['search-field2'] : '';


              $person1 = getPerson($db, $IIN1);
              $person2 = getPerson($db, $IIN2);

              if ($person1 && $person2) {
                  echo 'Поиск отношений между '.$person1['FirstName'].' '.$person1['LastName'].' и '.$person2['FirstName'].' '.$person2['LastName'].' <br>';
                  findRelations($db, $person1['id'], $person2['id']);
              } else {
                  echo "Either one or both of the persons with given IINs do not exist in the database\n";
              }




               ?>
              </div>
            </div>
          </div>



        </div>
      </div>
        <?php
        $page = "test";
        require_once(HOME_DIR.'/include/navmenu.php');
        ?>
      </body>
    </html>
