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
  <?php 
  $treemap = [
    'name' => '7080',
    'children' => []
  ];

  $transaction_type = [
      1 => 'Перевод',
      2 => 'Покупка',
      3 => 'Обналичивание',
      4 => 'Снятие из депозита'
  ];
  // echo $transaction_type[1];
  // $from = '2022-01-01';
  // $to = '2022-12-31';
  $displayed_transaction_types = [];
    if($query = $db->prepare("SELECT Sender, Receiver, Transaction_Type_ID, Transaction_Amount, Transaction_End_Date
      FROM operations
      WHERE Transaction_End_Date BETWEEN '2022-01-01' AND '2022-12-31';
      -- LIMIT 5
      ")) { 
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            if (! empty($row)) {
              if (!in_array($row["Transaction_Type_ID"], $displayed_transaction_types)){
                array_push($displayed_transaction_types, $row["Transaction_Type_ID"]);
                // echo 
                $transactions[] = [
                  'name' => $transaction_type[$row["Transaction_Type_ID"]],
                  'amount' => $row["Transaction_Amount"]
                ];
              }
              for ($i = 0; $i<count($transactions); $i++){
                if (isset($transactions[$i]['name']) && $transactions[$i]['name'] == $transaction_type[$row["Transaction_Type_ID"]]){
                  $transactions[$i]['amount'] = $transactions[$i]['amount'] + $row['Transaction_Amount'];
                }
              }
            }
            $transaction = [];
          }
        }
        if (!empty($displayed_transaction_types)){
          $treemap['children'] = $transactions;
        }
      }

      // echo json_encode($treemap, JSON_UNESCAPED_UNICODE);
      // echo 'C даты: ' . $from . ' По:' . $to;


?>
<div class="container rounded bg-white mt-5 mb-5">
  <div id='treemap-container'></div>

</div>


<script>
    var data = <?php echo json_encode($treemap, JSON_UNESCAPED_UNICODE); ?>
    // Установка размеров диаграммы
    var margin = {top: 10, right: 10, bottom: 10, left: 10};

    const width = 960;
    const height = 600;
    const format = d3.format(",d");

    const colorScale = d3.scaleOrdinal()
      .domain(data.children.map(d => d.name))
      .range(d3.schemeSet3);

    const treemapLayout = d3.treemap()
        .size([width, height])
        .padding(1)
        .round(true);

    const root = d3.hierarchy(data)
    .sum(d => d.amount)
    .sort((a, b) => b.height - a.height || b.value - a.value);

    treemapLayout(root);

    const svg = d3.select("#treemap-container")
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        .style("font", "20px sans-serif");

    const cell = svg.selectAll("g")
        .data(root.leaves())
        .join("g")
        .attr("transform", d => `translate(${d.x0},${d.y0})`);

    cell.append("rect")
        .attr("id", d => d.data.name)
        .attr("width", d => d.x1 - d.x0)
        .attr("height", d => d.y1 - d.y0)
        .attr("fill", d => colorScale(d.data.name));

    cell.append("clipPath")
        .attr("id", d => (d.clipUid = `clip-${d.data.name}`))
        .append("use")
        .attr("href", d => `#${d.data.name}`);

    cell.append("text")
        .attr("clip-path", d => `url(#${d.clipUid})`)
        .selectAll("tspan")
        .data(d => d.y1 - d.y0 >= 30 && d.x1 - d.x0 >= 70 ? [d.data.name, `${format(d.value)} (${((d.value / root.value) * 100).toFixed(2)}%)`] : [d.data.name])
        .join("tspan")
        .attr("x", 3)
        .attr("y", (d, i) => `${1 + i * 0.9}em`)
        .attr("fill-opacity", (d, i) => i === 0 ? 0.7 : 1)
        .text(d => d);



  </script>
</body>
</html>