<?php
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
    <div id="graph"></div>
    <?php 
      $id = $_GET['id'];
      $organization_ID = $_GET['organization_id'];
      $start_period = $_GET['start_period'];
      $end_period = $_GET['end_period'];
      $intersections = [];

      if($query = $db->prepare("
      SELECT persons.FirstName, persons.LastName, job_history.position_name, co_workers.FirstName as CoWorkerFirstName,
      co_workers.LastName as CoWorkerLastName, co_workers.position_name, co_workers.person_id, co_workers.Photo,
      co_workers.time_start_position, co_workers.time_end_position
      FROM job_history
      JOIN persons ON job_history.person_id = persons.id
      LEFT JOIN (
      SELECT persons.FirstName, persons.LastName, job_history.person_id, job_history.position_name, persons.Photo,
      job_history.time_start_position, job_history.time_end_position
      FROM job_history
      JOIN persons ON job_history.person_id = persons.id
      WHERE job_history.organization_ID = $organization_ID
      AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period'
      ) co_workers ON co_workers.person_id != job_history.person_id
      WHERE job_history.person_id = $id
      AND job_history.organization_ID = $organization_ID
      AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period' ;")) 
      {
        $query->execute();
        $result = $query->get_result();
          if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              if (! empty($row)) {
                $intersections[] = [
                  'id' => $row['person_id'],
                  'content' => $row['CoWorkerFirstName'] . ' ' . $row['CoWorkerLastName'],
                  'PositionName' => $row['position_name'],
                  'time_start_position' => $row['time_start_position'],
                  'time_end_position' => $row['time_end_position']
                ];
              }
            }
          }
      }
    ?>

    <script>
      // DOM element where the Timeline will be attached
      var container = document.getElementById('graph');

      // Create a DataSet (allows two way data-binding)
      var items = new vis.DataSet(<?php echo json_encode($intersections, JSON_UNESCAPED_UNICODE) ?>);

      // Configuration for the Timeline
      var options = {};

      // Create a Timeline
      var timeline = new vis.Timeline(container, items, options);
    </script>

      <?php
        if(!isset($_GET['id'])) {
          header("location: person.php");
        } else {
          $id = $_GET['id'];
          $organization_ID = $_GET['organization_id'];
          $start_period = $_GET['start_period'];
          $end_period = $_GET['end_period'];

          echo '
          <p class="text-center">
             Карьерные пересечения с <u>'.$start_period.'</u> по <u>'.$end_period.'</u>
          </p>
          ';

          if($end_period == "текущий момент"){$end_period='CURDATE()';};

          if($query = $db->prepare("
          SELECT persons.FirstName, persons.LastName, job_history.position_name, co_workers.FirstName as CoWorkerFirstName,
          co_workers.LastName as CoWorkerLastName, co_workers.position_name, co_workers.person_id, co_workers.Photo,
          co_workers.time_start_position, co_workers.time_end_position
          FROM job_history
          JOIN persons ON job_history.person_id = persons.id
          LEFT JOIN (
          SELECT persons.FirstName, persons.LastName, job_history.person_id, job_history.position_name, persons.Photo,
          job_history.time_start_position, job_history.time_end_position
          FROM job_history
          JOIN persons ON job_history.person_id = persons.id
          WHERE job_history.organization_ID = $organization_ID
          AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period'
          ) co_workers ON co_workers.person_id != job_history.person_id
          WHERE job_history.person_id = $id
          AND job_history.organization_ID = $organization_ID
          AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period' ;")) 
          {

            $query->execute();
            $result = $query->get_result();
            if ($row = $result->fetch_assoc()) 
            {
                if (! empty($row)) 
                {

                  echo '
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Аватар</th>
                          <th>Фамилия</th>
                          <th>Имя</th>
                          <th>Должность</th>
                          <th>Период работы</th>
                        </tr>
                      </thead>
                      <tbody>
                  ';

                  while ($row = $result->fetch_assoc()) {
                      $FirstName = $row['CoWorkerFirstName'];
                      $LastName = $row['CoWorkerLastName'];
                      $Position = $row['position_name'];
                      $coworker_id = $row['person_id'];
                      $Photo = 'images/avatars/persons/' . $row["Photo"];
                      $coworker_start_period = $row['time_start_position'];
                      $coworker_end_period = $row['time_end_position'];
                      if ($coworker_end_period == "0000-00-00") {
                      $coworker_end_period = "текущий момент";
                      }
                      echo
                      '<tr class="alert" role="alert">
                        <td class="d-flex align-items-center">
                          <div class="img" style="background-image: url('.$Photo.');"></div>
                        </td>
                        <td class="">
                          <a href="person-single.php?id='.$coworker_id.'"><span>'.$LastName.'</span></a>
                        </td>
                        <td class="">
                          <a href="person-single.php?id='.$coworker_id.'"><span>'.$FirstName.'</span></a>
                        </td>
                        <td class="">
                          <span>'.$Position.'</span>
                        </td>
                        <td class="">
                          <span>'.$coworker_start_period.' по '.$coworker_end_period.' </span>
                        </td>
                      </tr>';
                  }
                  echo '
                  </tbody>
                  </table>
                  ';
                }
            }else{
                header("Location:  person-single.php?id=$id");
                exit;
            }

          }

        }


        ?>

    </div>
  </div>

  <?php
    $page = "person_page";
    require_once(HOME_DIR.'/include/navmenu.php');
    ?>

</body>

</html>