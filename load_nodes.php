<?php
    if (isset($_POST['node_id'])) {
      $node_id = $_POST['node_id'];
      function test(){
        global $nodes, $edges;
        $nodes = [];
        $edges = [];
      }
      test();
    }
?>