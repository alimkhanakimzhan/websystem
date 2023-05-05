<?php
require_once "config.php";
?>


  <?php 
  $treemap = [
    'children' => []
  ];

  $transaction_type = [
    1 => 'Перевод',
    2 => 'Покупка',
    3 => 'Обналичивание',
    4 => 'Снятие из депозита',
    5 => 'Покупка акции',
    6 => 'Покупка иностранной валюты',
    7 => 'Дивиденды',
    8 => 'Комиссия за обслуживание счета',
    9 => 'Пополнение счета',
    10 => 'Покупка криптовалюты',
    11 => 'Займ',
    12 => 'Погашение займа',
    13 => 'Возврат товара',
    14 => 'Разблокировка средств',
    15 => 'Аренда недвижимости',
    16 => 'Продажа товара'
  ];

  
  $transaction_type_rgb = [
    1 => '#4DA6FF',
    2 => '#FFC107',
    3 => '#150080',
    4 => '#DC3545',
    5 => '#6F42C1',
    6 => '#007BFF',
    7 => '#17A2B8',
    8 => '#6610f2',
    9 => '#6f42c1',
    10 => '#e83e8c',
    11 => '#dc3545',
    12 => '#fd7e14',
    13 => '#ffc107',
    14 => '#28a745',
    15 => '#20c997',
    16 => '#6c757d'
  ];

  $currency_exchange_rate = [
    1 => 457.19
  ];

  $data = [];
  $displayed_transaction_types = [];
    if($query = $db->prepare("SELECT Transaction_Start_Date, Sender, Transaction_End_Date, Receiver, Transaction_Type_ID, Transaction_Amount, Currency_Type, Description
      FROM operations
      WHERE Sender = $iin 
      -- OR Receiver = $iin;
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
                  'color' => $transaction_type_rgb[$row["Transaction_Type_ID"]],
                  'amount' => 0,
                  'data' => []
                ];

                // $transaction[] = [
                //   'Transaction_Start_Date' => $row['Transaction_Start_Date'],
                //   'Sender' => $row['Sender'],
                //   'Transaction_End_Date' => $row['Transaction_End_Date'],
                //   'Receiver' => $row['Receiver'],
                //   'Transaction_Type_ID' => $row['Transaction_Type_ID'],
                //   'Transaction_Amount' => $row['Transaction_Amount'],
                //   // 'Currency_Type' => $row['Currency_Type'],
                //   'Description' => $row['Description'],
                // ];

                // array_push($transactions['data'], $transaction);

              }
              for ($i = 0; $i<count($transactions); $i++){
                if (isset($transactions[$i]['name']) && $transactions[$i]['name'] == $transaction_type[$row["Transaction_Type_ID"]]){
                  // echo $transactions[$i]['name']. ' ' .  $transaction_type[$row["Transaction_Type_ID"]] .'<br>';

                  if ((isset($row['Currency_Type']) && $row['Currency_Type'] == 0) && isset($transaction_type[$row["Transaction_Type_ID"]]) && $transaction_type[$row["Transaction_Type_ID"]] == $transactions[$i]['name']){
                    $transactions[$i]['amount'] = $transactions[$i]['amount'] + $row['Transaction_Amount'] ;
                    $data[$row["Transaction_Type_ID"]][] = [
                      'Transaction_Start_Date' => $row['Transaction_Start_Date'],
                      'Sender' => $row['Sender'],
                      'Transaction_End_Date' => $row['Transaction_End_Date'],
                      'Receiver' => $row['Receiver'],
                      'Transaction_Type_ID' => $row['Transaction_Type_ID'],
                      'Transaction_Amount' => $row['Transaction_Amount'],
                      'Currency_Type' => $row['Currency_Type'],
                      'Description' => $row['Description'],
                    ];

                    $transactions[$i]['data'] = $data[$row["Transaction_Type_ID"]];
                    // $data = [];
                  };
                  if (isset($row['Currency_Type']) && $row['Currency_Type'] == 1){
                    $data[$row["Transaction_Type_ID"]][]  = [
                      'Transaction_Start_Date' => $row['Transaction_Start_Date'],
                      'Sender' => $row['Sender'],
                      'Transaction_End_Date' => $row['Transaction_End_Date'],
                      'Receiver' => $row['Receiver'],
                      'Transaction_Type_ID' => $row['Transaction_Type_ID'],
                      'Transaction_Amount' => $row['Transaction_Amount'],
                      'Currency_Type' => $row['Currency_Type'],
                      'Description' => $row['Description'],
                    ];

                    $transactions[$i]['data'] = $data[$row["Transaction_Type_ID"]];
                    $transactions[$i]['amount'] = $transactions[$i]['amount'] + ($row['Transaction_Amount']);
                  }
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

?>


<script>
        var data = <?php echo json_encode($treemap, JSON_UNESCAPED_UNICODE); ?>
    
        const width = 1280;
        const height = 600;
        const treemapWidth = 800;

        const format = d3.format(",d");

        const treemapLayout = d3.treemap()
            .size([treemapWidth, height])
            .padding(1)
            .round(true);


        
        const root = d3.hierarchy(data)
            .sum(d => d.amount)
            // .sort((a, b) => b.value - a.value);

            .sort((a, b) => a.data.name.localeCompare(b.data.name) || b.value - a.value);

        treemapLayout(root);

        const sortedData = data.children.sort((a, b) => b.amount - a.amount);


        const svg = d3.select("#treemap-container")
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .style("font", "28px sans-serif");

        const cell = svg.selectAll("g")
            .data(root.leaves())
            .join("g")
            .attr("transform", d => `translate(${d.x0},${d.y0})`)
            .on("click", function(d) {
              // преобразуем объект в строку json
              const payloadStr = JSON.stringify(d.data.data);
              // создаем строку url с параметром, содержащим json payload
              const url = "treemapdata.php?payload=" + encodeURIComponent(payloadStr);
              // перенаправляем на другую страницу
              window.location.href = url;
            });


        cell.append("rect")
            .attr("id", d => d.data.name)
            .attr("width", d => d.x1 - d.x0)
            .attr("height", d => d.y1 - d.y0)
            .attr("fill", d => {
                while (d.depth > 1) d = d.parent;
                return d.data.color;
            })
            .style("cursor", "pointer")


        
        cell.append("title")
            .text((d) => `${d.data.name}`)
            // .attr("transform", "translate(40, 60)")
            .style('font', '28px sans-serif');


        cell.append("clipPath")
            .attr("id", d => (d.clipUid = `clip-${d.data.name}`))
            .append("use")
            .attr("href", d => `#${d.data.name}`);

        cell.append("text")
            .attr("clip-path", d => `url(#${d.clipUid})`)
            .attr("text-anchor", "middle")
            .attr("dy", "0.35em")
            .attr("x", d => (d.x1 - d.x0) / 2)
            .attr("y", d => (d.y1 - d.y0) / 2)
            .attr("fill-opacity", d => (d.y1 - d.y0 >= 30 && d.x1 - d.x0 >= 70) ? 1 : 0)
            .text(d => `${((d.value / root.value) * 100).toFixed(2)}%`)
            .style('font', '24px sans-serif');

        // Legenda
        const legend = svg.append("g")
            .attr("transform", "translate(820, 50)");
            // .attr('legend')
            
        legend.append("text")
            .text("Обзор")
            .attr("x", 0)
            .attr("y", -20)
            // .attr("text-anchor", "middle")
            .style("font", "28px sans-serif");

        legend.selectAll("rect")
            .data(sortedData)
            .data(data.children)
            .enter()
            .append("rect")
            .attr("x", 0)
            .attr("y", (d, i) => i * 30)
            .attr("width", 20)
            .attr("height", 20)
            .attr("fill", d => d.color);

        legend.selectAll("legend-text")
            .data(sortedData)
            .data(data.children)
            .enter()
            .append("text")
            .attr("x", 30)
            .attr("y", (d, i) => i * 30 + 15)
            .attr("dy", "0.35em")
            .text(d => `${d.name}: ${format(d.amount)} (${((d.amount / root.value) * 100).toFixed(2)}%)`)
            .style("font", "16px sans-serif");
    </script>