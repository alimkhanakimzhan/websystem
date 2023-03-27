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
              <form class="container mt-5" action="person.php" method="GET">
                      <div class="row d-flex justify-content-center">
                          <div class="col-md-10">
                              <div class="card p-3  py-4">
                                  <h5>Поиск гражданина:</h5>
                                  <div class="row g-3 mt-2">
                                      <div class="col-md-9">
                                          <input name="search-field" type="text" class="form-control" placeholder="Введите ИИН, пример: 010203040506">
                                      </div>
                                      <div class="col-md-3">
                                          <button class="btn btn-secondary btn-block">Найти</button>
                                      </div>
                                  </div>
                                <div class="mt-3">
                                  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="advanced">
                                    Дополнительные параметры <i class="fa fa-angle-down"></i>
                                  </a>
                                  <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                      <div class="row">
                                          <div class="col-md-4">
                                              <input type="text" class="form-control" placeholder="Имя" name="FirstName">
                                          </div>
                                          <div class="col-md-4">
                                              <input type="text" class="form-control" placeholder="Фамилия" name="LastName">
                                          </div>
                                          <div class="col-md-4">
                                              <input type="text" class="form-control" placeholder="Отчество" name="Patronymic">
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                      </div>
                    </form>
<!-- search form end-->




      <?php


          $search_field_parameter = isset($_GET['search-field']) ? $_GET['search-field'] : '';
          $firstName_request = isset($_GET['FirstName']) ? $_GET['FirstName'] : '';
          $lastName_request = isset($_GET['LastName']) ? $_GET['LastName'] : '';
          $patronymic_request = isset($_GET['Patronymic']) ? $_GET['Patronymic'] : '';


          if($search_field_parameter =='' AND $firstName_request =='' AND  $lastName_request =='' AND $patronymic_request ==''){
            if($query = $db->prepare("SELECT persons.id, IIN, FirstName, LastName, Patronymic, Photo, gender.name, BirthDate, regions.name as PlaceOfBirth, nationalities.nationality as nationality 
            FROM persons INNER JOIN gender ON gender.id = persons.GenderID 
            INNER JOIN regions ON regions.id = persons.birth_region_id 
            INNER JOIN nationalities ON nationalities.id = persons.nationality_id 
            ORDER BY `persons`.`ID` ASC LIMIT 50; ")) {

              $query->execute();
              $result = $query->get_result();
              echo '

                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>Аватар</th>
                      <th>ИИН</th>
                      <th>Имя</th>
                      <th>Фамилия</th>
                      <th>Отчество</th>
                      <th>Место Рождения</th>
                    </tr>
                  </thead>
                  <tbody>
              ';
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $iin = $row["IIN"];
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $Patronymic = $row["Patronymic"];
                    $BirthDate = $row["BirthDate"];
                    $PlaceOfBirth = $row["PlaceOfBirth"];
                    $Photo = 'images/avatars/persons/' . $row["Photo"];

                    echo '

                    <tr class="alert" role="alert">
                      <td class="d-flex align-items-center">
                        <div class="img" style="background-image: url('.$Photo.');"></div>
                      </td>
                      <td class="">
                        <a href=person-single.php?id='.$id.'> <span>'.$iin.'</span> </a>

                      </td>
                      <td class="">
                        <span>'.$FirstName.'</span>
                      </td>
                      <td class="">
                        <span>'.$LastName.'</span>
                      </td>
                      <td class="">
                        <span>'.$Patronymic.'</span>
                      </td>
                      <td class="">
                        <span>'.$PlaceOfBirth.'</span>
                      </td>
                    </tr>';
                }
                echo '
                </tbody>
                </table>

                ';
            /*freeresultset*/
            $result->free();
            }

          } else {
          $query = "SELECT persons.id, IIN, FirstName, LastName, Patronymic, Photo, Gender.Gender, BirthDate, regions_list.name as PlaceOfBirth, nationality_list.nationality as nationality FROM person INNER JOIN Gender ON Gender.id = person.Gender INNER JOIN regions_list ON regions_list.id = person.PlaceOfBirth INNER JOIN nationality_list ON nationality_list.id = person.Nationality WHERE ";


          if($search_field_parameter !=''){
              $query .= "IIN LIKE '{$search_field_parameter}%' AND ";
          }
          if($firstName_request !=''){
              $query .= "FirstName LIKE '{$firstName_request}%' AND ";
          }
          if($lastName_request !=''){
              $query .= "LastName LIKE '{$lastName_request}%' AND ";
          }
          if($patronymic_request !=''){
              $query .= "Patronymic LIKE '{$patronymic_request}%' AND ";
          }

          $query = rtrim($query, "AND ");
          $query .= "ORDER BY `person`.`id` LIMIT 50";

          if($query = $db->prepare($query) ) {

            $query->execute();
            $result = $query->get_result();
            if($result->num_rows > 0) {
              echo '
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>Аватар</th>
                      <th>ИИН</th>
                      <th>Имя</th>
                      <th>Фамилия</th>
                      <th>Отчество</th>
                      <th>Место Рождения</th>
                    </tr>
                  </thead>
                  <tbody>
              ';
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $iin = $row["IIN"];
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $Patronymic = $row["Patronymic"];
                    $BirthDate = $row["BirthDate"];
                    $PlaceOfBirth = $row["PlaceOfBirth"];
                    $Photo = $row["Photo"];


                    echo '

                    <tr class="alert" role="alert">
                      <td class="d-flex align-items-center">
                        <div class="img" style="background-image: url('.$Photo.');"></div>
                      </td>
                      <td class="">
                        <a href=person-single.php?id='.$id.'> <span>'.$iin.'</span> </a>

                      </td>
                      <td class="">
                        <span>'.$FirstName.'</span>
                      </td>
                      <td class="">
                        <span>'.$LastName.'</span>
                      </td>
                      <td class="">
                        <span>'.$Patronymic.'</span>
                      </td>
                      <td class="">
                        <span>'.$PlaceOfBirth.'</span>
                      </td>
                    </tr>';
                }
                echo '
                </tbody>
                </table>

                ';
            /*freeresultset*/
            $result->free();

            }
            else {
              echo '
              <p class="text-center">
              Ничего не найдено!
              </p>

              ';
            }

          }

          }





      ?>

  </table>




  </div>
    </div>
        <?php
        $page = "person_page";
        require_once(HOME_DIR.'/include/navmenu.php');
        ?>
      </body>
    </html>
