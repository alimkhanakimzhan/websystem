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

  $id = 53;
  if($query = $db->prepare("SELECT persons.id, IIN, FirstName, LastName, Patronymic, Photo, gender.name as Gender, BirthDate, regions.name as PlaceOfBirth, nationalities.nationality as Nationality
  FROM persons LEFT JOIN gender ON gender.id = persons.GenderID
  LEFT JOIN regions ON regions.id = persons.birth_region_id
  LEFT JOIN nationalities ON nationalities.id = persons.nationality_id
  WHERE persons.id = $id ORDER BY `persons`.`id` ASC LIMIT 5")) {
  $query->execute();
  $result = $query->get_result();
  if ($row = $result->fetch_assoc()) {
    if (! empty($row)) {
          $iin = $row['IIN'];
          $FirstName = $row['FirstName'];
          $LastName = $row['LastName'];
          $Patronymic = $row['Patronymic'];
          $Gender = $row['Gender'];
          $BirthDate = $row['BirthDate'];
          $PlaceOfBirth = $row['PlaceOfBirth'];
          $Nationality = $row['Nationality'];
          $Photo = '../images/avatars/persons/' . $row["Photo"];
        }
        }
    }
    else {
      header("Location:  index.php");
      exit;
    }

?>
<html>
  <?php require_once(HOME_DIR.'/include/header.php') ?>
  <body>
    <div class="wrapper">
      <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
          <div class="col-md-3 border-right">
              <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" height="150px" src="<?php echo ($Photo == 'images/avatars/persons/') ? $Photo.'default_icon.png' : $Photo; ?>">

                <span class="font-weight-bold"><?php echo $FirstName; echo " "; echo $LastName; ?></span>
              </div>
          </div>
          <div class="col-md-5 border-right">
              <div class="p-3 py-5">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="text-right">Личные данные</h4>
                  </div>
                  <div class="row mt-2">
                      <div class="col-md-12"><label class="labels">ИИН</label><input  type="text" class="form-control" placeholder="" value="<?php echo $iin; ?>"></div>
                      <div class="col-md-12"><label class="labels">Фамилия</label><input type="text" class="form-control" value="<?php echo $LastName?>"></div>
                      <div class="col-md-12"><label class="labels">Имя</label><input type="text" class="form-control" value="<?php echo $FirstName?>"></div>
                      <div class="col-md-12"><label class="labels">Отчество</label><input type="text" class="form-control" value="<?php if($Patronymic != "NULL" ) echo $Patronymic ?>"></div>
                    </div>

                  <div class="mt-5 text-center">
                    <button class="btn btn-primary profile-button" type="button">Save Profile</button>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Дополнительные данные</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Национальность</label><input type="text" class="form-control" placeholder="<?php echo $Nationality; ?>" value="" readonly></div>
                    <div class="col-md-12"><label class="labels">Пол</label><input type="text" class="form-control" placeholder="<?php echo $Gender; ?>" value="" readonly></div>
                    <div class="col-md-12"><label class="labels">Дата Рождения</label><input type="text" class="form-control" placeholder="<?php echo $BirthDate; ?>" value="" readonly></div>
                    <div class="col-md-12"><label class="labels">Место Рождения</label><input type="text" class="form-control" value="" placeholder="<?php echo $PlaceOfBirth; ?>" readonly></div>
                </div>
              </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="container rounded bg-white mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Семья</h4>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="row mt-3">
                <?php
                    if($query = $db->prepare("SELECT b.FirstName, b.LastName, relative_id, relationship_type.Name, relationship_type.priority
                    FROM persons a INNER JOIN relatives ON relatives.person_id = a.id
                    INNER JOIN persons b ON b.id = relatives.relative_id
                    INNER JOIN relationship_type ON relatives.relationship_id = relationship_type.id
                    WHERE person_id =$id ORDER BY relationship_type.priority")) {

                    $query->execute();
                    $result = $query->get_result();
                    if($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                            if (! empty($row)) {
                                  $user_id = $row['relative_id'];
                                  $full_name = $row['FirstName']." ".$row['LastName'];
                                  $relationship_type = $row['Name'];

                                  if($user_id!=0){
                                    // Надо поменять ссылки
                                    echo '


                                      <div class="col-md-6">
                                        <label class="labels"><b>'.$relationship_type.'</b></label>
                                        <p>
                                          <a href=person-single.php?id='.$user_id.'>
                                            '.$full_name.'
                                          </a>
                                          <i class="fa fa-minus-circle fa-s"></i>
                                        </p>

                                      </div>
                                    ';
                                  }
                                  else {
                                    echo '


                                      <div class="col-md-6">
                                        <label class="labels"><b>'.$relationship_type.'</b></label>
                                          <p>
                                          '.$full_name.'
                                          </p>
                                        <i class="fa fa-minus-circle fa-s"></i>
                                      </div>
                                    ';
                                  }


                                }
                              }
                            }
                            else {
                              echo '
                              <div class="col-md-3">
                                Неизвестно
                              </div>';
                            }

                      }

                  ?>

              </div>
            </div>
            <div class="col-md-6">

                <div class="col-md-12"><label class="labels">Выберите человека</label><input type="text" class="form-control" value="" readonly></div>
                <div class="col-md-12"><label class="labels">Тип отношения</label><input type="text" class="form-control" value="" readonly></div>
                <div class="mt-5 text-center">
                  <button class="btn btn-primary profile-button" type="button">+ Add new member</button>
                </div>

            </div>
          </div>
        </div>


     <hr>

     <div class="container rounded bg-white mt-5 mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="text-right">Карьерная История</h4>
      </div>

      <?php
      if($query = $db->prepare("SELECT time_start_position, time_end_position,  position_name, organization_ID, organization_list.Name as organization_name FROM `job_history` INNER JOIN persons on persons.id=job_history.person_id
                                INNER JOIN organization_list on organization_ID=organization_list.id
                                WHERE person_id = $id ORDER BY time_start_position DESC")) {

        $query->execute();
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
            $time_start_position = $row["time_start_position"];
            $time_end_position = $row["time_end_position"];
            if ($time_end_position == "0000-00-00") {
              $time_end_position = date('Y-m-d');
            }
            $organization_id = $row["organization_ID"];
            $organization_name = $row["organization_name"];
            $position_name = $row["position_name"];



            echo '

            <div class="row mt-3">
                <div class="col-md-12"><label class="labels">Место Работы <a href="career-intersections.php?id='.$id.'&organization_id='.$organization_id.'&start_period='.$time_start_position.'&end_period='.$time_end_position.'">(Карьерные пересечения)</a></label><input type="text" class="form-control" placeholder="'.$organization_name.'" value="" readonly></div>
                <div class="col-md-12"><label class="labels">Должность</label>
                <input type="text" class="form-control" placeholder="'.$position_name.'" value="" readonly>
                </div>';

                if ($time_end_position == date('Y-m-d')) {
                $time_end_position = "текущий момент";}
                echo '
                <div class="col-md-12"><label class="labels">Период работы:</label>
                с '.$time_start_position.' по '.$time_end_position.'
                </div>
            </div>
            <hr />
            ';
          }
        $result->free();
        }
      ?>
      </div>
    </div>
    <?php $page = "person_page";
          require_once(HOME_DIR.'/admin/include/navmenu.php');
    ?>
  </body>
</html>
