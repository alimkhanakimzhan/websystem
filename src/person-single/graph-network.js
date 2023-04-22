// Определение функции, которая принимает три параметра nodes, edges и displayed_ids
function drawGraph(nodes, edges, displayed_ids) {
    var container = document.getElementById('graph-network-vis');
    // console.log('');

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
      
    var loaded_nodes = Object.values(Object.assign({}, nodes));  // make a copy of nodes and edges without keys that we are going to load into the network (if we leave the keys, visjs won't understand the inserted data)
    var loaded_edges = Object.values(Object.assign({}, edges)); 

    var network = new vis.Network(container, { nodes: loaded_nodes, edges: loaded_edges }, options);
    var chosen_node = undefined;
    
    
    
    network.on("click", function (obj) {
    chosen_node = this.getNodeAt(obj.pointer.DOM);
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
            nodes = response.nodes;
            edges = response.edges;
            displayed_ids = response.displayed_ids;
            // alert(displayed_ids.length);

            loaded_nodes = Object.values(Object.assign({}, nodes));  // make a copy of nodes and edges without keys that we are going to load into the network (if we leave the keys, visjs won't understand the inserted data)
            loaded_edges = Object.values(Object.assign({}, edges));
            network.setData({ nodes: loaded_nodes, edges: loaded_edges });
    
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
    
    
        // var newNode = {
        //   id: nodes.length + 1, // Generate a new ID for the node
        //   name: "neww",
        //   image: "",
        //   href: '',
        //   label: "1212"
        // };
    
        // var newEdge = {
        //   from: node_id,
        //   to: nodes.length + 1,
        //   relationship_type: ""
        // };
    
        // nodes.push(newNode); // Add the new node to the nodes array
        // edges.push(newEdge);
        //network.setData({ nodes: nodes, edges: edges }); // Update the network data
    
        //alert(chosen_node);
    
    }
    });
}