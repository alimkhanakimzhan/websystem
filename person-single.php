<?php
// start the session
session_start();

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if(!isset($_GET['id'])) {
  header("location: person.php");
}
else {
  $id = $_GET['id'];
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
              <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" height="150px" src="<?php echo ($Photo == 'images/avatars/persons/') ? $Photo.'default_icon.png' : $Photo; ?>">

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
                      <div class="col-md-12"><label class="labels">ИИН</label><input  type="text" class="form-control" placeholder="<?php echo $iin; ?>" value="" readonly></div>
                      <div class="col-md-12"><label class="labels">ФИО</label><input type="text" class="form-control" value="" placeholder="<?php echo $LastName; echo " "; echo $FirstName; echo " "; if($Patronymic != "NULL" ) echo $Patronymic ?>" readonly></div>
                      <div class="col-md-12"><label class="labels">Место Рождения</label><input type="text" class="form-control" value="" placeholder="<?php echo $PlaceOfBirth; ?>" readonly></div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-md-12"><label class="labels">Национальность</label><input type="text" class="form-control" placeholder="<?php echo $Nationality; ?>" value="" readonly></div>
                      <div class="col-md-12"><label class="labels">Пол</label><input type="text" class="form-control" placeholder="<?php echo $Gender; ?>" value="" readonly></div>
                      <div class="col-md-12"><label class="labels">Дата Рождения</label><input type="text" class="form-control" placeholder="<?php echo $BirthDate; ?>" value="" readonly></div>
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
                if($query = $db->prepare("SELECT time_start_position, time_end_position,  position_name, organization_list.name as organization_name FROM `job_history` INNER JOIN persons on persons.id=job_history.person_id
                                          INNER JOIN organization_list on organization_ID=organization_list.id
                                          WHERE person_id = $id and time_end_position = '0000-00-00 00:00' ORDER BY time_start_position DESC")) {
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
                      <hr />
                      ';
                    }
                  }
                    else {
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

     <div class="container rounded bg-white mt-5 mb-5">
       <div id="network"></div>
        <?php
          $nodes[] = [
            'id' => $id,
            'name' => $FirstName . ' ' . $LastName,
            'image' => (($Photo=='images/avatars/persons/')?'images/avatars/persons/default_icon.png':$Photo),
            'href' => 'person-single.php?id=' . $id,
            'label' => '<b>' . $FirstName . ' ' . $LastName . '</b>',
            'font' => [
              'multi' =>  "html", 
              'size' =>  20
            ]
          ];
          $edges = [];
          // $displayed_ids = array($id);

          //query after UNION is added in case backward relative connection wasn't added to DB
          if($query = $db->prepare("SELECT relative_id, relative_name, relative_photo, relationship_type FROM (SELECT b.id as relative_id, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name, b.Photo as relative_photo, relationship_type.Name as relationship_type FROM relatives INNER JOIN persons b ON relatives.relative_id = b.id
          INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
          WHERE relatives.person_id =$id 
          UNION 
          SELECT b.id as relative_id, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name, b.Photo as relative_photo, CONCAT(relationship_type.Name, ' человека')  as relationship_type FROM relatives
          INNER JOIN persons b ON relatives.person_id = b.id
          INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
          WHERE relatives.relative_id = $id) as person_relatives WHERE relative_id not in ('') GROUP BY person_relatives.relative_id;")){
            $query->execute();
            $result = $query->get_result();
            if($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                if (! empty($row)) {

                //   if (in_array($row['relative_id'], $displayed_ids)){
                //     continue;
                // }
                // array_push($displayed_ids, $row['relative_id']);

                  $nodes[] = [
                    'id' => $row['relative_id'],
                    'name' => $row['relative_name'],
                    'image' => 'images/avatars/persons/' . (($row['relative_photo']=='')?'default_icon.png':$row['relative_photo']),
                    'href' => 'person-single.php?id=' . strtolower(str_replace(' ', '', $row['relative_id'] )),
                    'label' => $row['relationship_type']."\n".$row['relative_name']
                  ];

<<<<<<< Updated upstream
                  $edges[] = [
                    'from' => $id,
                    'to' => $row['relative_id'],
                    'relationship_type' => $row['relationship_type'],
                  ];
=======
          function add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges){

            global $query, $db;
            $displayed_ids_string = implode(',', $displayed_ids);

            //query after UNION is added in case backward relative connection wasn't added to DB
            if($query = $db->prepare("SELECT relative_id, relative_name, relative_photo, relationship_type FROM (SELECT b.id as relative_id, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name, 
            b.Photo as relative_photo, relationship_type.Name as relationship_type FROM relatives 
            INNER JOIN persons b ON relatives.relative_id = b.id
            INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
            WHERE relatives.person_id =$node_id
            UNION 
            SELECT b.id as relative_id, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name, b.Photo as relative_photo, CONCAT(relationship_type.Name, ' человека')  as relationship_type FROM relatives
            INNER JOIN persons b ON relatives.person_id = b.id
            INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
            WHERE relatives.relative_id = $node_id) as person_relatives WHERE relative_id not in ($displayed_ids_string) GROUP BY person_relatives.relative_id;")){
              $query->execute();
              $result = $query->get_result();
              if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  if (! empty($row)) {

                    if (in_array($row['relative_id'], $displayed_ids)){
                      continue;
                    }
                    array_push($displayed_ids, $row['relative_id']);

                    $nodes[] = [
                      'id' => $row['relative_id'],
                      'name' => $row['relative_name'],
                      'image' => 'images/avatars/persons/' . (($row['relative_photo']=='')?'default_icon.png':$row['relative_photo']),
                      'href' => 'person-single.php?id=' . strtolower(str_replace(' ', '', $row['relative_id'] )),
                      'label' => $row['relationship_type']."\n".$row['relative_name']
                    ];

                    $edges[] = [
                      'from' => $node_id,
                      'to' => $row['relative_id'],
                      'relationship_type' => $row['relationship_type'],
                    ];
                  }
>>>>>>> Stashed changes
                }
              }
            }
<<<<<<< Updated upstream
          }
=======

            return array($nodes, $edges, $displayed_ids);
          }

          $network_data = add_relatives_nodes($id, $displayed_ids, $nodes, $edges);

          $nodes = $network_data[0];
          $edges = $network_data[1];
          $displayed_ids = $network_data[2];

>>>>>>> Stashed changes
        ?>

        <script>
              var container = document.getElementById('network');

<<<<<<< Updated upstream
              var nodes = <?php echo json_encode($nodes, JSON_UNESCAPED_UNICODE) ?>;
              var edges = <?php echo json_encode($edges, JSON_UNESCAPED_UNICODE) ?>;

              var data = {
                  nodes: nodes,
                  edges: edges
              };

              var options = {
                  layout: {
                      hierarchical: false
                  },

                  physics: {  // Настройки физики
                      forceAtlas2Based: {  // Используется алгоритм ForceAtlas2 для расчета физики
                          gravitationalConstant: -200,  // Коэффициент гравитации. Отрицательное значение делает узлы отталкивающими друг друга
                          centralGravity: 0.005,  // Коэффициент центральной гравитации. Определяет насколько сильно центральный узел будет притягивать другие узлы
                          springLength: 100,  // Длина пружины. Определяет, насколько далеко узлы могут быть друг от друга
                          springConstant: 0.02,  // Коэффициент жесткости пружины. Определяет, насколько быстро узлы будут двигаться к своей нормальной длине пружины
                          damping: 0.4,  // Коэффициент затухания. Определяет, насколько быстро узлы будут останавливаться
                          avoidOverlap: 0  // Коэффициент избегания перекрытия узлов. Устанавливается в 1 для предотвращения перекрытий
                      },
                      maxVelocity: 50,  // Максимальная скорость узлов
                      minVelocity: 0.1,  // Минимальная скорость узлов
                      solver: "forceAtlas2Based",  // Используется алгоритм ForceAtlas2 для решения физических конфликтов
                      timestep: 0.5,  // Интервал времени между расчетами физики
                      stabilization: { iterations: 2000 }  // Количество итераций стабилизации после рисования графа. Нужно для предотвращения дрожания узлов
                  },
=======
        var nodes = <?php echo json_encode($nodes, JSON_UNESCAPED_UNICODE) ?>;
        var edges = <?php echo json_encode($edges, JSON_UNESCAPED_UNICODE) ?>;
        var displayed_ids = <?php echo json_encode($displayed_ids, JSON_UNESCAPED_UNICODE) ?>;

>>>>>>> Stashed changes

                  nodes: {
                      shape: "circularImage",
                      size: 70, // Размер узлов
                      distance: 1250,
                      shapeProperties: {
                              useImageSize: true
                      },
                      borderWidth: 2,
                      borderWidthSelected: 4,
                      font: {
                          color: '#343434',
                          size: 16,
                          face: 'arial',
                          background: 'none',
                          strokeWidth: 0,
                          strokeColor: '#ffffff'
                      },
                      color: {
                          border: '#2B7CE9',
                          background: '#97C2FC',
                          highlight: {
                              border: '#2B7CE9',
                              background: '#D2E5FF'
                          },
                          hover: {
                              border: '#2B7CE9',
                              background: '#D2E5FF'
                          }
                      }
                  },

                  edges: {
                      size: 40,
                      length: 400,
                      smooth: {
                          type: 'continuous'
                      },
                      width: 2,
                      color: {
                          color: '#757575',
                          highlight: '#757575',
                          hover: '#757575'
                      }
                  },
                  interaction: {
                      hover: true,
                      navigationButtons: true,
                      keyboard: true,
                      zoomView: false // запрещаем масштабирование с помощью мыши
                  },
                  // manipulation: {
                      // enabled: true // добавляет функцию редактирования графика по идее не нужно?
                  // }
              };

              var network = new vis.Network(container, data, options);

              // network.on("click", function (obj) {
              //     alert(this.getNodeAt(obj.pointer.DOM));
              // });

              network.on("doubleClick", function (params) {
                  var node = network.getNodeAt(params.pointer.DOM);
                  for(i in nodes){
                    if (nodes[i]["id"] == node){
                      var href = nodes[i]["href"];
                      break;
                    }
                  }
                  window.open(href, '_blank');
              });

          </script>
     </div>
     <hr>

<<<<<<< Updated upstream
     <div class="container rounded bg-white mt-5 mb-5">
=======
        network.on("doubleClick", function (obj) {
          if (this.getNodeAt(obj.pointer.DOM) != undefined) {
            var node = network.getNodeAt(obj.pointer.DOM);
            for (i in nodes) {
              if (nodes[i]["id"] == node) {
                var href = nodes[i]["href"];
                break;
              }
            }
            window.open(href, '_blank');
          }
        });

        $("#searchFurther").click(function (obj) {
          if (chosen_node != undefined) {

            $.ajax({
              type: "POST",
              url: "load_nodes.php", // Send the AJAX request to the same page
              dataType: 'json',
              cache: false,
              data: {
                node_id: chosen_node,
                displayed_ids: displayed_ids,
                nodes: nodes,
                edges: edges
              },
              success: function(response) {
                // The AJAX request was successful, do something here if needed

                nodes = response.nodes;
                edges = response.edges;
                displayed_ids = response.displayed_ids;
                alert(displayed_ids.length);
                network.setData({ nodes: nodes, edges: edges });

                // nodes.forEach(function(entry) {
                //   console.log(entry);
                // });

                // edges.forEach(function(entry) {
                //   console.log(entry);
                // });

              },
              error: function() {
                // The AJAX request failed, do something here if needed
                alert("AJAX request failed");
              }
            });
          }
        });
      </script>
    </div>
    <hr>

    <div class="container rounded bg-white mt-5 mb-5">
>>>>>>> Stashed changes
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
          require_once(HOME_DIR.'/include/navmenu.php');
    ?>
  </body>
</html>
