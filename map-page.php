<?php
// start the session
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
    <div class="wrapper">
      <div class="container rounded mt-5 mb-5">
      <div class="row">
          <div class="col-md-10 border-right">
            <div id="map"></div>
          </div>
          <div class="col-md-2">
            
            <p> 
            <?php
            echo "<h1>Kazakhstan</h1>";
            ?> 
            </p>
          </div>
        </div>
      </div>
        <style>
          #map {
            background-color: transparent !important;
            height: 550px;
            width: 940px;

            
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
          }

          body {
            overflow: hidden;
          }
        </style>
    <script>
            
    
    

        async function fetchData() {
            var geojson = {
                "type": "FeatureCollection",
                "features": []
            };
            geojson.pushgeojson = async function(area) {
                const response = await fetch('./src/geojson/' + area);
                const json = await response.json();
                this.features.push(...json.features);
            };

            const regions = ['1__astana.geojson', '2__almaty.geojson', 
            'karagandyprovince.geojson',
             '5__akmolaprovince.geojson', '6__aktobeprovince.geojson', 
            '7__almatyprovince.geojson', '8__atyrauprovince.geojson', 
            '9__eastkazakhstan.geojson', 
            '10__jambylprovince.geojson', 
            '12__westkazakhstan.geojson',
            '14__kostanayprovince.geojson', '15__kyzylordaprovince.geojson', 
            '16__mangystauprovince.geojson', '17__pavlodar.geojson', '18__northkazakhstan.geojson', 
            '19__turkistanprovince.geojson', 
            ];

            for (i in regions){
                await geojson.pushgeojson(regions[i]);
            };            

            return geojson;
        };

        var map = L.map("map", {
            zoomControl: false, // убрал переключатели для увеличения карты
            scrollWheelZoom: false, // убрал мастабирование карты
            interactive: false, // убрал интерактивность
            dragging: false, // убрал захват и движение карты
            doubleClickZoom: false, // убрал функцию увеличения карты по нажатию
            attributionControl: false // убрал что-то 

        }).setView([48.5, 67.0], 5.4);

        async function map_interaction_main_function() {
            // добавление слоя GeoJSON на карту
            var geojson = await fetchData();
            defaultStyle =  {
                weight: 2,
                opacity: 1,
                color: "#1E90FF",
                fillOpacity: 0.1,
                fillColor: "#1E90FF"
            };

            var geojsonLayer = L.geoJson(geojson, {
                style: function (feature) {
                return {
                    weight: 2,
                    opacity: 1,
                    color: "#1E90FF",
                    fillOpacity: 0.1,
                    fillColor: "#1E90FF"
                };
                }
            }).addTo(map);

            geojsonLayer.eachLayer(function (layer) {
                // выполнение действий при клике на область
                layer.on("click", function () {
                  var regionName = layer.feature.properties.name;
                  document.querySelector("h1").textContent = regionName;

                    map.fitBounds(layer.getBounds()); // зумируем на выбранный регион
                    geojsonLayer.setStyle(function(feature) {
                        if (feature == layer.feature) {
                            return {
                                weight: 2,
                                opacity: 1,
                                color: "#1E90FF",
                                fillOpacity: 0.1,
                                fillColor: "#1E90FF"
                            }
                        } else {
                            return {
                                weight: 2,
                                opacity: 1,
                                color: "#000000",
                                fillOpacity: 0.5,
                                fillColor: "#000000"
                            }
                        }
                    });
                });

                // выполнение действий при двойном клике
                layer.on("dblclick", function () {
                // Переход на координаты [48.5, 67.0], зум 5.4
                map.setView([48.5, 67.0], 5);
                geojsonLayer.setStyle(defaultStyle);
                document.querySelector("h1").textContent = 'Kazakhstan';
              });
            });
            
            
            // часть кода что обрабатывает увеличение масштаба
            // map.on('zoomend', function() {
            //     var zoom = map.getZoom();
            //     console.log('Zoom level: ' + zoom);
            // });
            // Создаем окружность с начальными координатами
            
            return geojsonLayer;
        }

        (async function () {
            var geojsonLayer = await map_interaction_main_function();

          // Do something with the GeoJSON layer
        })();    
    </script>
  
      </div>
    </div>

    <?php
    $page = "map_page";
    require_once(HOME_DIR.'/include/navmenu.php');
    ?>
  </body>
</html>
