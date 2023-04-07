<?php

    require_once "config.php";

    if (isset($_POST['node_id']) && isset($_POST['displayed_ids']) && isset($_POST['nodes']) && isset($_POST['edges'])) {

        $node_id = $_POST['node_id'];
        $displayed_ids = $_POST['displayed_ids'];
        $nodes = $_POST['nodes'];
        $edges = $_POST['edges'];
        function add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges){

            global $query, $db;
            $displayed_ids_string = implode(',', $displayed_ids);
            $is_on = [$node_id => "NO"]; // есть ли человек на графике

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
                  if (! empty($row)) {

                    if (in_array($row['relative_id'], $displayed_ids)){
                        $is_on[] = [$row['relative_id'] => "YES"];
                        $edges[] = [
                          'from' => $node_id,
                          'to' => $row['relative_id'],
                          'relationship_type' => $row['relationship_type'],
                          'label' => $row['relationship_type']
                        ];
                        continue;
                    }

                    $is_on[] = [$row['relative_id'] => "NO"];
                    array_push($displayed_ids, $row['relative_id']);
                    


                    $nodes[] = [
                      'id' => $row['relative_id'],
                      'name' => $row['relative_name'],
                      'image' => 'images/avatars/persons/' . (($row['relative_photo']=='')?'default_icon.png':$row['relative_photo']),
                      'href' => 'person-single.php?id=' . strtolower(str_replace(' ', '', $row['relative_id'] )),
                      'label' => $row['relative_name']
                    ];

                    $edges[] = [
                      'from' => $node_id,
                      'to' => $row['relative_id'],
                      'relationship_type' => $row['relationship_type'],
                      'label' => $row['relationship_type']
                    ];
                  }
                }
              }
            }

            return array("displayed_ids" => $displayed_ids,
                        "nodes" => $nodes,
                        "edges" => $edges,
                        "is_on" => $is_on);
          }



      echo json_encode(add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges));

    }
?>
