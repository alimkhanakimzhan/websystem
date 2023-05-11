// Определение функции, которая принимает три параметра nodes, edges и displayed_ids
function drawGraph(nodes, edges, displayed_ids) {
    var container = document.getElementById('graph-network-vis');

    // Код для создания графа с помощью библиотеки Network
    var options = {
        layout: {
          hierarchical: false
        },
      
        physics: { // Настройки физики
          forceAtlas2Based: { // Используется алгоритм ForceAtlas2 для расчета физики
            gravitationalConstant: -
            200, // Коэффициент гравитации. Отрицательное значение делает узлы отталкивающими друг друга
            centralGravity: 0.005, // Коэффициент центральной гравитации. Определяет насколько сильно центральный узел будет притягивать другие узлы
            springLength: 100, // Длина пружины. Определяет, насколько далеко узлы могут быть друг от друга
            springConstant: 0.02, // Коэффициент жесткости пружины. Определяет, насколько быстро узлы будут двигаться к своей нормальной длине пружины
            damping: 0.4, // Коэффициент затухания. Определяет, насколько быстро узлы будут останавливаться
            avoidOverlap: 0 // Коэффициент избегания перекрытия узлов. Устанавливается в 1 для предотвращения перекрытий
          },
          maxVelocity: 50, // Максимальная скорость узлов
          minVelocity: 0.1, // Минимальная скорость узлов
          solver: "forceAtlas2Based", // Используется алгоритм ForceAtlas2 для решения физических конфликтов
          timestep: 0.5, // Интервал времени между расчетами физики
          stabilization: {
            iterations: 2000
          } // Количество итераций стабилизации после рисования графа. Нужно для предотвращения дрожания узлов
        },
      
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
          arrows: {
            to: {
              enabled: true,
              scaleFactor: 1,
              type: "arrow"
            }
          },
          font: {
            color: '#0f5587',
            size: 16, // px
            face: 'arial',
            background: 'none',
            strokeWidth: 2, // px
            strokeColor: '#ffffff',
            align: 'horizontal',
            multi: false,
            vadjust: 0,
      
          },
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
      
    var loaded_nodes = new vis.DataSet(Object.values(Object.assign({}, nodes)));  // make a copy of nodes and edges without keys that we are going to load into the network (if we leave the keys, visjs won't understand the inserted data)
    var loaded_edges = new vis.DataSet(Object.values(Object.assign({}, edges))); 

    var network = new vis.Network(container, { nodes: loaded_nodes, edges: loaded_edges }, options);
    var chosen_node = undefined;
    var chosen_radio = $('input[name="radioOptions"]:checked').val();
    
    $('input[type=radio][name=radioOptions]').change(function() {
      chosen_radio = $('input[name="radioOptions"]:checked').val();
    });
    
    
    network.on("click", function (obj) {
    chosen_node = this.getNodeAt(obj.pointer.DOM);
    switch(chosen_radio) {
      case 'find':
        if (chosen_node != undefined) {
          console.log(nodes);
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
              // console.log(response.echo); // for debug purposes
              nodes = Object.assign({}, nodes, response.nodes);
              edges = Object.assign({}, edges, response.edges);
              displayed_ids = response.displayed_ids;

              console.log(response.nodes);
              console.log(response.edges);
              loaded_nodes.add(Object.values(response.nodes));
  
              loaded_edges.add(Object.values(response.edges));
  
          },
          error: function() {
              // The AJAX request failed, do something here if needed
              alert("AJAX request failed");
          }
          });
  
        }
        break;
      case 'hide':
        if (chosen_node != undefined) {

          loaded_nodes.remove(nodes[chosen_node]);
          console.log(nodes[chosen_node]);
          delete nodes[chosen_node];
          for (var i = displayed_ids.length - 1; i >= 0; i--) {
            if (displayed_ids[i] === chosen_node) {
              displayed_ids.splice(i, 1);
            }
          }
          console.log(displayed_ids);
          for (var key in edges) {
            if (key.startsWith(chosen_node + "-") || key.endsWith("-" + chosen_node) ) {
              loaded_edges.remove(edges[key]);
              console.log(edges[key]);
              delete edges[key];
            }
          }
        }
        break;
      case 'idle':
        break;
      default:
        $('#result').text('Please select a fruit.');
    }
    });
    
    network.on("doubleClick", function (obj) {
    if (this.getNodeAt(obj.pointer.DOM) != undefined) {
        var node = network.getNodeAt(obj.pointer.DOM);
        for (i in nodes) {
        if (nodes[i]["id"] == node) {
            var href = nodes[i]["href"];
            break;
        }
        }
        window.location.href = (href);
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
            // console.log(response.echo); // for debug purposes
            nodes = Object.assign({}, nodes, response.nodes);
            edges = Object.assign({}, edges, response.edges);
            displayed_ids = response.displayed_ids;
            // alert(displayed_ids.length);
            // loaded_nodes.add(Object.values(Object.assign({}, nodes)));
            // loaded_edges.add();

            // loaded_nodes = Object.values(Object.assign({}, nodes));  // make a copy of nodes and edges without keys that we are going to load into the network (if we leave the keys, visjs won't understand the inserted data)
            // loaded_edges = Object.values(Object.assign({}, edges));
            // network.setData({ nodes: loaded_nodes, edges: loaded_edges });
            // for (let i = 0; i < ids.length; i++){
            //   treeData.nodes.update({id:ids[i],hidden:true})
            // }   
            

            loaded_nodes.add(Object.values(response.nodes));

            loaded_edges.add(Object.values(response.edges));

        },
        error: function() {
            // The AJAX request failed, do something here if needed
            alert("AJAX request failed");
        }
        });

    }
    });
}