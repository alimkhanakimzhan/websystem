<?php
// start the session
session_start();
// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//
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
                  <input name="search-field" type="text" class="form-control"
                    placeholder="Введите ИИН, пример: 010203040506">
                </div>
                <div class="col-md-3">
                  <button class="btn btn-secondary btn-block">Найти</button>
                </div>
              </div>
              <div class="mt-3">
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                  aria-controls="collapseExample" class="advanced"> Дополнительные параметры <i
                    class="fa fa-angle-down"></i>
                </a>
                <div class="collapse" id="collapseExample">
                  <div class="card card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Фамилия" name="LastName">
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Имя" name="FirstName">
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
            if($query = $db->prepare("SELECT IIN, LastName, FirstName, Patronymic, Photo, PDL_FLAG, State_Employee_FLAG, Law_Enforcement_Officer_FLAG, organization_list.name as organization_name
               -- gender.name, BirthDate, regions.name as PlaceOfBirth, nationalities.nationality as nationality
            FROM persons 
            -- INNER JOIN gender ON gender.id = persons.GenderID
            -- INNER JOIN regions ON regions.id = persons.birth_region_id
            -- INNER JOIN nationalities ON nationalities.id = persons.nationality_id
            INNER JOIN job_history ON persons.IIN = job_history.person_iin
            INNER JOIN organization_list on organization_ID=organization_list.id
            WHERE job_history.time_end_position = '0000-00-00 00:00' 

            ORDER BY persons.Photo DESC LIMIT 50; ")) { 
              // есть ошибка связанная с работай и отображением то есть может существовать человек 
              //с несколькими должностями и кроме того в базе может присутсвовать персоны чья работа не определена точно
              // прим Алия Назарбаевна у нее несколько должностей которые без указания когда ее сняли с работы
              $query->execute();
              $result = $query->get_result();
              echo '
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>Аватар</th>
                      <th>ИИН</th>
                      <th>Фамилия</th>
                      <th>Имя</th>
                      <th>Отчество</th>
                      <th>Текущее место работы</th>
                    </tr>
                  </thead>
                  <tbody>
              ';
                while ($row = $result->fetch_assoc()) {
                    $iin = $row["IIN"];
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $Patronymic = $row["Patronymic"];
                    $Photo = 'images/avatars/persons/' . (($row["Photo"] == '') ? 'default_icon.png' : $row["Photo"]);
                    $CurrentWorkPlace = $row["organization_name"];
                    echo '
                    <tr class="alert" role="alert">
                      <td class="d-flex align-items-center">
                        <div class="img" style="background-image: url('.$Photo.');"></div>
                      </td>
                      <td class="">
                        <a href=person-single.php?iin='.$iin.'> <span>'.$iin.'</span> </a>
                      </td>
                      <td class="">
                        <span>'.$LastName.'</span>
                      </td>
                      <td class="">
                        <span>'.$FirstName.'</span>
                      </td>
                      <td class="">
                        <span>'.$Patronymic.'</span>
                      </td>
                      <td class="">
                        <span>'.$CurrentWorkPlace.'</span>
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
          $query = "SELECT IIN, FirstName, LastName, Patronymic, Photo, organization_list.name as organization_name
          -- , gender.name
          -- , nationalities.nationality as nationality
          FROM persons
          -- INNER JOIN gender ON gender.id = persons.GenderID
          -- INNER JOIN regions ON regions.id = persons.birth_region_id
          INNER JOIN job_history ON persons.IIN = job_history.person_iin
          INNER JOIN organization_list on organization_ID=organization_list.id
          -- INNER JOIN nationalities ON nationalities.id = persons.nationality_id
          WHERE 
          job_history.time_end_position = '0000-00-00 00:00' 
          AND
           ";

          //  Запрос показывает последнию работу персоны если есть работы не известные
          // $query = "SELECT
          //  persons.IIN, 
          //     persons.FirstName, 
          //     persons.LastName, 
          //     persons.Patronymic, 
          //     persons.Photo, 
          //     organization_list.name as organization_name
          //   FROM persons
          //   INNER JOIN (
          //     SELECT person_iin, MAX(time_end_position) as last_time_end
          //     FROM job_history
          //     GROUP BY person_iin
          //   ) AS last_job ON persons.IIN = last_job.person_iin
          //   INNER JOIN job_history ON persons.IIN = job_history.person_iin AND job_history.time_end_position = last_job.last_time_end
          //   INNER JOIN organization_list ON job_history.organization_ID = organization_list.id
          //   Where
            
          //  ";


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
          $query .= "AND `persons`.`IIN` not in ('', '-') ORDER BY persons.Photo LIMIT 50";

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
                      <th>Фамилия</th>
                      <th>Имя</th>
                      <th>Отчество</th>
                      <th>Текущее место работы</th>
                    </tr>
                  </thead>
                  <tbody>
              ';
                while ($row = $result->fetch_assoc()) {
                    $iin = $row["IIN"];
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $Patronymic = $row["Patronymic"];
                    // $BirthDate = $row["BirthDate"];
                    // $PlaceOfBirth = $row["PlaceOfBirth"];
                    $Photo = 'images/avatars/persons/' .  (($row["Photo"] == '') ? 'default_icon.png' : $row["Photo"]);
                    $CurrentWorkPlace = $row["organization_name"];

                    echo '
                    <tr class="alert" role="alert">
                      <td class="d-flex align-items-center">
                        <div class="img" style="background-image: url('.$Photo.');"></div>
                      </td>
                      <td class="">
                        <a href=person-single.php?iin='.$iin.'> <span>'.$iin.'</span> </a>

                      </td>
                      <td class="">
                        <span>'.$LastName.'</span>
                      </td>
                      <td class="">
                        <span>'.$FirstName.'</span>
                      </td>
                      <td class="">
                        <span>'.$Patronymic.'</span>
                      </td>
                      <td class="">
                        <span>'.$CurrentWorkPlace.'</span>
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
  <?php $page = "person_page";
          require_once(HOME_DIR.'/include/navmenu.php');
    ?>
</body>
</html>
