<?php 
// start the session
// session_start(); // doesnt need session already started in person-single

// Check if the user is not logged in, then redirect the user to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

function add_relatives_nodes($node_id, $displayed_ids, $nodes, $edges){
    global $query, $db;
    $displayed_ids_string = implode(',', $displayed_ids);

    //query after UNION is added in case backward relative connection wasn't added to DB
    if($query = $db->prepare("SELECT relative_iin, relative_name, relative_photo, relationship_type 
    FROM (SELECT b.IIN as relative_iin, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name,
      b.Photo as relative_photo, relationship_type.Name as relationship_type FROM relatives
      INNER JOIN persons b ON relatives.relative_iin = b.IIN
      INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
      WHERE relatives.person_iin =$node_id
      UNION
      SELECT b.IIN as relative_iin, CONCAT(b.LastName, ' ' ,b.FirstName) as relative_name, b.Photo as relative_photo, relationship_type.Name  as relationship_type FROM relatives
      INNER JOIN persons b ON relatives.person_iin = b.IIN
      INNER JOIN relationship_type ON relationship_type.id = relatives.relationship_id
      WHERE relatives.relative_iin = $node_id) as person_relatives 
    WHERE relative_iin not in ($displayed_ids_string) 
    GROUP BY person_relatives.relative_iin;")) {
      $query->execute();
      $result = $query->get_result();
      if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $relative_iin = $row['relative_iin'];
          $relative_name = $row['relative_name'];
          $relative_photo = $row['relative_photo'];
          $relationship_type = $row['relationship_type'];

          if (! empty($row)) {
            if (in_array($relative_iin, $displayed_ids)){
              continue;
            }
            array_push($displayed_ids, $relative_iin);

            $nodes[$relative_iin] = [
              'id' => $relative_iin,
              'name' => $relative_name,
              'image' => 'images/avatars/persons/' . (($relative_photo=='')?'default_icon.png':$relative_photo),
              'href' => 'person-single.php?iin=' . strtolower(str_replace(' ', '', $relative_iin )),
              'label' => $relative_name ."\n". $relative_iin
            ];

            $edges[$node_id.'-'.$relative_iin] = [
              'from' => $node_id,
              'to' => $relative_iin,
              'relationship_type' => $relationship_type,
              'label' => $relationship_type,
              'id' => $node_id.'-'.$relative_iin
            ];
          }
        }
        $displayed_ids_string = implode(',', $displayed_ids); //update list of displayed arrays
      }
    }
    return array($nodes, $edges, $displayed_ids);
  }

?>