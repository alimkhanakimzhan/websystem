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




    function loadNewNodes(chosen_node) {
      return new Promise((resolve, reject) => {
          $.ajax({
              type: "POST",
              url: "load_nodes.php", 
              dataType: 'json',
              cache: false,
              data: {
                  node_id: chosen_node,
                  displayed_ids: displayed_ids,
                  nodes: nodes,
                  edges: edges
              },
              success: function(response) {
                  nodes = Object.assign({}, nodes, response.nodes);
                  edges = Object.assign({}, edges, response.edges);
                  displayed_ids = response.displayed_ids;
                  loaded_nodes.add(Object.values(response.nodes));
                  loaded_edges.add(Object.values(response.edges));
                  resolve();
              },
              error: function() {
                  alert("AJAX request failed");
                  reject();
              }
          });
      });
  }
  
  
  async function recursiveSearch(chosen_node){
      var init_id_list = [...displayed_ids];
      var lengthDiff = 0;
      var addedValues = [];
      await loadNewNodes(chosen_node);
      if (displayed_ids.length > init_id_list.length){
          lengthDiff = displayed_ids.length - init_id_list.length;
          addedValues = displayed_ids.slice(-(lengthDiff));
          for(let node_id of addedValues){
            await recursiveSearch(node_id);
          }
      }else{
          return;
      }
  }



    
    $('input[type=radio][name=radioOptions]').change(function() {
      chosen_radio = $('input[name="radioOptions"]:checked').val();
    });
    
    
    network.on("click", function (obj) {
    chosen_node = this.getNodeAt(obj.pointer.DOM);
    switch(chosen_radio) {
      case 'find':
        if (chosen_node != undefined) {
          loadNewNodes(chosen_node);
  
        }
        break;
      case 'findAll':
        if (chosen_node != undefined) {
          recursiveSearch(chosen_node);
  
        }
        break;
      case 'hide':
        if ((chosen_node != undefined) && chosen_node != displayed_ids[0]){

          loaded_nodes.remove(nodes[chosen_node]);
          delete nodes[chosen_node];
          for (var i = displayed_ids.length - 1; i >= 0; i--) {
            if (displayed_ids[i] == chosen_node) {
              displayed_ids.splice(i, 1);
            }
          }
          for (var key in edges) {
            if (key.startsWith(chosen_node + "-") || key.endsWith("-" + chosen_node) ) {
              loaded_edges.remove(edges[key]);
              delete edges[key];
            }
          }
        }
        break;
      case 'idle':
        break;
      default:
        break;
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
    
}