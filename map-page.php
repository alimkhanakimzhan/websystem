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
      <div id="map"></div>
        <style>
          #map {
            background-color: transparent !important;
            height: 800px;
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
                await console.log(regions[i])
            };            

            console.log(geojson);
            return geojson;
        };

        var map = L.map("map", {
            zoomControl: false, // убрал переключатели для увеличения карты
            scrollWheelZoom: false, // убрал мастабирование карты
            interactive: false,
            dragging: false,
            doubleClickZoom: false,
            attributionControl: false

        }).setView([48.5, 67.0], 5.4);

        async function map_interaction_main_function() {
            // добавление слоя GeoJSON на карту
            var geojson = await fetchData();
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

            // установка обработчика событий на клик по области
            geojsonLayer.eachLayer(function (layer) {
                layer.on("click", function () {
                // выполнение действий при клике на область
                console.log("Клик по области " + layer.feature.properties.name);
                });
            });
            
            // часть кода что обрабатывает увеличение масштаба
            // map.on('zoomend', function() {
            //     var zoom = map.getZoom();
            //     console.log('Zoom level: ' + zoom);
            // });

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
