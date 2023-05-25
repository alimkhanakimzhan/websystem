<?php
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if(!isset($_GET['iin'])) {
  header("location: person.php");
}
else {
  $iin = $_GET['iin'];
  if($query = $db->prepare("SELECT IIN, FirstName, LastName, Patronymic, Photo, gender.name as Gender, BirthDate, regions.name as PlaceOfBirth, nationalities.nationality as Nationality
  FROM persons LEFT JOIN gender ON gender.id = persons.GenderID
  LEFT JOIN regions ON regions.id = persons.birth_region_id
  LEFT JOIN nationalities ON nationalities.id = persons.nationality_id
  WHERE persons.IIN = $iin ORDER BY `persons`.`IIN` ASC LIMIT 5")) {
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
          $Photo = 'images/avatars/persons/' . $row["Photo"];
        }
        }
    }
    else {
      header("Location:  index.php");
      exit;
    }
}
?>
<html>
<?php require_once(HOME_DIR.'/include/header.php') ?>

<body>
  <div class="wrapper">
    <div class="container rounded bg-white mt-5 mb-5">
      <div class="row">
        <div class="col-md-3 border-right">
          <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
              width="150px" height="150px"
              src="<?php echo ($Photo == 'images/avatars/persons/') ? $Photo.'default_icon.png' : $Photo; ?>">

            <span class="font-weight-bold"><?php echo $FirstName; echo " "; echo $LastName; ?></span>
            <!-- <span class="text-black-50"><?php echo "Должность"; ?></span>
                <span> <?php echo "Место работы"; ?> </span> -->
          </div>
        </div>
        <div class="col-md-5 border-right">
          <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="text-right">Личные данные</h4>
            </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <label class="labels">ИИН</label>
                <input type="text" class="form-control" placeholder="<?php echo $iin; ?>" value="" readonly>
              </div>
              <div class="col-md-12">
                <label class="labels">ФИО</label>
                <input type="text" class="form-control" value="" placeholder="<?php echo $LastName; echo " "; echo $FirstName; echo " "; if($Patronymic != "NULL" ) echo $Patronymic ?>" readonly>
              </div>
              <div class="col-md-12">
                <label class="labels">Место Рождения</label>
                <input type="text" class="form-control" value="" placeholder="<?php echo $PlaceOfBirth; ?>" readonly>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <label class="labels">Национальность</label>
                <input type="text" class="form-control" placeholder="<?php echo $Nationality; ?>" value="" readonly>
              </div>
              <div class="col-md-12">
                <label class="labels">Пол</label>
                <input type="text" class="form-control" placeholder="<?php echo $Gender; ?>" value="" readonly>
              </div>
              <div class="col-md-12">
                <label class="labels">Дата Рождения</label>
                <input type="text" class="form-control" placeholder="<?php echo $BirthDate; ?>" value="" readonly>
              </div>
            </div>
            <!-- <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div> -->
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="text-right">Текущая работа</h4>
            </div>
            <?php
              if($query = $db->prepare("SELECT time_start_position, time_end_position, position_name, organization_list.name as organization_name FROM `job_history` INNER JOIN persons on persons.IIN=job_history.person_iin
              INNER JOIN organization_list on organization_ID=organization_list.id
              WHERE person_iin = $iin and time_end_position = '0000-00-00 00:00' ORDER BY time_start_position DESC
              LIMIT 1")) {
                $query->execute();
                $result = $query->get_result();
                if($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $time_start_position = $row["time_start_position"];
                    $organization_name = $row["organization_name"];
                    $position_name = $row["position_name"];

                    echo '
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Место работы (текущее)</label><input type="text" class="form-control" placeholder="'.$organization_name.'" value="" readonly></div>
                        <div class="col-md-12"><label class="labels">Должность</label><input type="text" class="form-control" value="" placeholder="'.$position_name.'" readonly></div>
                    </div>
                    ';
                  }
                } else {
                  echo
                  '
                  <div class="row mt-3">
                    <div class="col-md-12">Неизвестно</div>
                  </div>
                  ';
                }
              }

            ?>
          </div>

          <div class="p-3 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="text-right">Статус</h4>
            </div>
            <?php
              if($query = $db->prepare("SELECT persons.PDL_FLAG, persons.State_Employee_FLAG, persons.Law_Enforcement_Officer_FLAG
                FROM persons
                WHERE persons.IIN = $iin
                LIMIT 1;")) {
                  $query->execute();
                  $result = $query->get_result();
                  if($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $PDL_FLAG = $row["PDL_FLAG"];
                      $State_Employee_FLAG = $row["State_Employee_FLAG"];
                      $Law_Enforcement_Officer_FLAG = $row["Law_Enforcement_Officer_FLAG"];

                      if ($PDL_FLAG == 1){
                        echo '
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels"></label><input type="text" class="form-control" placeholder="ПДЛ" value="" readonly></div>
                        </div>
                        ';};
                      if ($State_Employee_FLAG == 1){
                        echo '
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels"></label><input type="text" class="form-control" placeholder="Государственный служащий" value="" readonly></div>
                        </div>
                        ';};
                      if ($Law_Enforcement_Officer_FLAG == 1){
                        echo '
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels"></label><input type="text" class="form-control" placeholder="Сотрудник правоохранительного органа" value="" readonly></div>
                        </div>
                        ';};
                      if ($PDL_FLAG == 0 AND $State_Employee_FLAG == 0 AND $Law_Enforcement_Officer_FLAG == 0){
                        echo '
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels"></label><input type="text" class="form-control" placeholder="Неизвестно" value="" readonly></div>
                        </div>
                        ';
                      };
                    };
                  }
                }
              ?>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <div class="container rounded bg-white mt-5 mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-right">Семья</h4>
      </div>
      <div class="row mt-3">
        <?php
          if($query = $db->prepare("SELECT a.relative_iin, b.LastName, b.FirstName, relationship_type.Name, relationship_type.priority
          FROM relatives a
          INNER JOIN relationship_type ON a.relationship_id = relationship_type.id
          
          INNER JOIN persons b ON b.IIN = a.relative_iin
          WHERE person_iin = $iin ORDER BY relationship_type.priority")) {

          $query->execute();
          $result = $query->get_result();
          if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              if (! empty($row)) {
                $user_id = $row['relative_iin'];
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
                      </p>
                    </div>
                  ';
                } else {
                  echo '
                  <div class="col-md-6">
                    <label class="labels"><b>'.$relationship_type.'</b></label>
                      <p>
                      '.$full_name.'
                      </p>
                  </div>';
                }
              }
            }
            } else {
              echo '
              <div class="col-md-3">
                Неизвестно
              </div>';
            }
          }
        ?>
      </div>
    </div>

    <hr>
    
    <!-- Отображение семейный связей -->
    <div class="container">
      <h1 class="mt-5 mb-3 text-center">Графическое отображение <br> родственных связей</h1>
      <div class="container">
        <ul class="nav nav-tabs justify-content-center mb-3 text-light p-3 rounded">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#nav-graph-network"  color: #000000;>Графовая сеть</a>
          </li>
        </ul>
      </div>

      <!-- Сеть связей -->
      <div class="tab-content container">
        <div class="tab-pane fade active show align-items-center" id="nav-graph-network">
          <button class="btn btn-primary" name="searchFurther" id="searchFurther">Найти родственников</button>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio1" value="find" checked>
            <label class="form-check-label" for="inlineRadio1">Найти новые связи</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio2" value="findAll">
            <label class="form-check-label" for="inlineRadio2">Найти все связи</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio3" value="hide">
            <label class="form-check-label" for="inlineRadio3">Скрыть человека</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio4" value="idle">
            <label class="form-check-label" for="inlineRadio4">Idle mode</label>
          </div>

          <div id="graph-network-vis"></div>
          <?php
            $nodes['graph-network'][$iin] = [
              'id' => $iin,
              'name' => $FirstName . ' ' . $LastName,
              'image' => (($Photo=='images/avatars/persons/')?'images/avatars/persons/default_icon.png':$Photo),
              'href' => 'person-single.php?iin=' . $iin,
              'label' => '<b>' . $FirstName . ' ' . $LastName . '</b>',
              'font' => [
                'multi' =>  "html",
                'size' =>  20
              ]
            ];
            $edges['graph-network'] = [];
            
            $displayed_ids = array($iin);
            //$displayed_ids_string = implode(',', $displayed_ids);
            require(HOME_DIR.'/src/person-single/graph-network.php');
            $network_data = add_relatives_nodes($iin, $displayed_ids, $nodes['graph-network'], $edges['graph-network']);

            // echo json_encode($network_data[0]['graph-network'], JSON_UNESCAPED_UNICODE);

            $nodes = $network_data[0];
            $edges = $network_data[1];
            $displayed_ids = $network_data[2];
          ?>

          <script>
            var nodes = <?php echo json_encode($nodes, JSON_UNESCAPED_UNICODE) ?>;
            var edges = <?php echo json_encode($edges, JSON_UNESCAPED_UNICODE) ?>;
            var displayed_ids = <?php echo json_encode($displayed_ids, JSON_UNESCAPED_UNICODE) ?>;

            drawGraph(nodes, edges, displayed_ids);
          </script>
        </div>
        
    </div>
    
    <hr>
    
    <!-- Древовидная карта -->
    <div class="container rounded bg-white mt-5 mb-5">
      <h2 class="mt-5 mb-3 text-center">Операции</h4>
      <div id='treemap-container'></div>
      <?php require(HOME_DIR.'/src/person-single/treemap.php')?>
    </div>

    <hr>

    <div class="container rounded bg-white mt-5 mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-right">Карьерная История</h4>
      </div>

      <?php
        if($query = $db->prepare("SELECT time_start_position, time_end_position,  position_name, organization_ID, organization_list.Name as organization_name 
        FROM `job_history` 
        INNER JOIN persons on persons.IIN=job_history.person_iin
        INNER JOIN organization_list on organization_ID=organization_list.id
        WHERE person_iin = $iin ORDER BY time_start_position DESC")) {

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
                <div class="col-md-12"><label class="labels">Место Работы <a href="career-intersections.php?iin='.$iin.'&organization_id='.$organization_id.'&start_period='.$time_start_position.'&end_period='.$time_end_position.'">(Карьерные пересечения)</a></label><input type="text" class="form-control" placeholder="'.$organization_name.'" value="" readonly></div>
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
  </div>
  <?php $page = "person_page";
          require_once(HOME_DIR.'/include/navmenu.php');
    ?>
</body>
</html>