<?php
    // start the session
    session_start();

    // Check if the user is not logged in, then redirect the user to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require_once "config.php";

    if (isset($_POST['node_id']) && isset($_POST['displayed_ids']) && isset($_POST['nodes']) && isset($_POST['edges'])) {

        $node_id = $_POST['node_id'];
        $displayed_ids = $_POST['displayed_ids'];
        $nodes = $_POST['nodes'];
        $edges = $_POST['edges'];
        function add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges){

            global $query, $db;
            $displayed_ids_string = implode(',', $displayed_ids);
            // $is_on = [$node_id => "NO"]; // есть ли человек на графике

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
            WHERE relatives.relative_id = $node_id) as person_relatives GROUP BY person_relatives.relative_id;")){
              $query->execute();
              $result = $query->get_result();
              if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $relative_id = $row['relative_id'];
                  $relative_name = $row['relative_name'];
                  $relative_photo = $row['relative_photo'];
                  $relationship_type =  $row['relationship_type'];

                  if (! empty($row)) {

                    if (in_array($relative_id, $displayed_ids)){
                        // $is_on[] = [$relative_id => "YES"];  // wrote this chunk of code to avoid 2 arrows in both directions (between 2 people)
                        // foreach ($edges as $edge) {
                        //   if ($edge['from'] == $relative_id && $edge['to'] == $node_id) {
                        //       $relative_edge = $edge;
                        //       break;
                        //   }
                        // }

                        // if (!($relationship_type == $relative_edge['label']) || !(($relationship_type.' человека') == $relative_edge['label'])){}
    
                        $edges[] = [
                          'from' => $node_id,
                          'to' => $relative_id,
                          'relationship_type' => $relationship_type,
                          'label' => $relationship_type
                        ];
                        continue;
                    }

                    // $is_on[] = $relative_id => "NO"];
                    array_push($displayed_ids, $relative_id);
                    


                    $nodes[] = [
                      'id' => $relative_id,
                      'name' => $relative_name,
                      'image' => 'images/avatars/persons/' . (($relative_photo=='')?'default_icon.png':$relative_photo),
                      'href' => 'person-single.php?id=' . strtolower(str_replace(' ', '', $relative_id )),
                      'label' => $relative_name
                    ];

                    $edges[] = [
                      'from' => $node_id,
                      'to' => $relative_id,
                      'relationship_type' => $relationship_type,
                      'label' => $relationship_type
                    ];
                  }
                }
              }
            }

            return array("displayed_ids" => $displayed_ids,
                        "nodes" => $nodes,
                        "edges" => $edges);
          }



      echo json_encode(add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges));

    }
?>
