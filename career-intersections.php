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
      $iin = $_GET['iin'];
      $organization_ID = $_GET['organization_id'];
      $start_period = $_GET['start_period'];
      $end_period = $_GET['end_period'];
      $intersections = [];
      $counter = 1;



      if($query = $db->prepare("
      SELECT persons.FirstName, persons.LastName, job_history.position_name, co_workers.FirstName as CoWorkerFirstName,
      co_workers.LastName as CoWorkerLastName, co_workers.position_name, co_workers.person_iin, co_workers.Photo,
      co_workers.time_start_position, co_workers.time_end_position
      FROM job_history
      JOIN persons ON job_history.person_iin = persons.iin
      LEFT JOIN (
      SELECT persons.FirstName, persons.LastName, job_history.person_iin, job_history.position_name, persons.Photo,
      job_history.time_start_position, job_history.time_end_position
      FROM job_history
      JOIN persons ON job_history.person_iin = persons.iin
      WHERE job_history.organization_ID = $organization_ID
      AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period'
      ) co_workers ON co_workers.person_iin != job_history.person_iin
      WHERE job_history.person_iin = $iin
      AND job_history.organization_ID = $organization_ID
      AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period' ORDER BY co_workers.time_start_position ASC;"))
      {
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            if (! empty($row)) {

              if ($row['time_end_position']=="0000-00-00"){
                $date = new DateTime(); // create a new DateTime object with the current date and time
                $end_date = $date->format('Y-m-d');
              } else {
                $end_date = $row['time_end_position'];
              };

              $intersections[] = [
                'id' => $counter,
                'content' => $row['CoWorkerFirstName'] . ' ' . $row['CoWorkerLastName'] . '<br>' . $row['position_name'],
                'start' => $row['time_start_position'],
                'end' => $end_date
              ];


              $counter+=1;
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
      // Assign a unique color to each item
      var colors = new vis.DataSet();
      var colorCount = 0;
      items.forEach(function(item) {
        var color = {id: item.id, background: 'rgb(' + colorCount*30 + ',' + colorCount*20 + ',' + colorCount*10 + ')'};
        colors.add(color);
        colorCount++;
      });

      // Configuration for the Timeline
      var options = {
        // width: '1000px',
        height: '70%',
        orientation: 'top',
        stack: true,
        align: 'left',
        tooltip: {
          followMouse: true,
          overflowMethod: 'flip',
          delay: 200,
          template: function(item) {
            return item.content;
          }
        }

      };


      // Create a Timeline
      var timeline = new vis.Timeline(container, items, options);
    </script>

      <?php
        if(!isset($_GET['iin'])) {
          header("location: person.php");
        } else {
          $iin = $_GET['iin'];
          $organization_ID = $_GET['organization_id'];
          $start_period = $_GET['start_period'];
          $end_period = $_GET['end_period'];

          echo '
          <p class="text-center">
             Карьерные пересечения с <u>'.$start_period.'</u> по <u>'.$end_period.'</u>
          </p>
          ';


          if($query = $db->prepare("
          SELECT persons.FirstName, persons.LastName, job_history.position_name, co_workers.FirstName as CoWorkerFirstName,
          co_workers.LastName as CoWorkerLastName, co_workers.position_name, co_workers.person_iin, co_workers.Photo,
          co_workers.time_start_position, co_workers.time_end_position
          FROM job_history
          JOIN persons ON job_history.person_iin = persons.iin
          LEFT JOIN (
          SELECT persons.FirstName, persons.LastName, job_history.person_iin, job_history.position_name, persons.Photo,
          job_history.time_start_position, job_history.time_end_position
          FROM job_history
          JOIN persons ON job_history.person_iin = persons.iin
          WHERE job_history.organization_ID = $organization_ID
          AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period'
          ) co_workers ON co_workers.person_iin != job_history.person_iin
          WHERE job_history.person_iin = $iin
          AND job_history.organization_ID = $organization_ID
          AND job_history.time_start_position BETWEEN '$start_period' AND '$end_period' ORDER BY co_workers.time_start_position ASC ;"))
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
                  if ($row['time_end_position'] == "0000-00-00") {
                  $row['time_end_position'] = "текущий момент";
                  }
                  echo
                      '<tr class="alert" role="alert">
                        <td class="d-flex align-items-center">
                          <div class="img" style="background-image: url('.'images/avatars/persons/' . $row["Photo"].');"></div>
                        </td>
                        <td class="">
                          <a href="person-single.php?id='.$row['person_iin'].'"><span>'.$row['CoWorkerLastName'].'</span></a>
                        </td>
                        <td class="">
                          <a href="person-single.php?id='.$row['person_iin'].'"><span>'.$row['CoWorkerFirstName'].'</span></a>
                        </td>
                        <td class="">
                          <span>'.$row['position_name'].'</span>
                        </td>
                        <td class="">
                          <span>'.$row['time_start_position'].' по '.$row['time_end_position'].' </span>
                        </td>
                      </tr>';

                  while ($row = $result->fetch_assoc()) {
                      $FirstName = $row['CoWorkerFirstName'];
                      $LastName = $row['CoWorkerLastName'];
                      $Position = $row['position_name'];
                      $coworker_id = $row['person_iin'];
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
            }
            else{
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
