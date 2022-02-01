<!DOCTYPE HTML>
<html lang="en">
  <head>


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
      html, body {
        height: 100%;
        padding: 0;
        margin: 0;
      }
      #map {
        /* configure the size of the map */
        width: 90%;
        height: 90%;

  margin: auto;

  border: 3px solid black;
  padding: 10px;
}
      }
    </style>
  </head>


  <body>
    <div id="map"></div>
    <script>
  // initialize Leaflet
  var map = L.map('map').setView({lon: 0, lat: 0}, 2);

  // add the OpenStreetMap tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,

  }).addTo(map);

  // show the scale bar on the lower left corner
  L.control.scale({imperial: true, metric: true}).addTo(map);


  /*
  $.getJSON( $bigfoot_api)
    .done(function( data ) {

      data.forEach(function (item, index) {
         L.marker({lat: item['latitude'], lon: item['longitude']}).bindPopup(item['title']).addTo(map);
      });
        
      });
*/

map.on(
  'moveend', 
  function() { 

    var map_bounds = [
      map.getBounds().getSouth(),
      map.getBounds().getWest(),
      map.getBounds().getNorth(),
      map.getBounds().getEast()
   ];
    console.log( map_bounds);

    var post_data = {
      'bounds':JSON.stringify(map_bounds)
    }
    $.post(
      "bigfoot_api.php?method=get_points", 
      post_data, 
      function(data, textStatus) {
        data.forEach(function (item, index)  {
          L.marker({lat: item['latitude'], lon: item['longitude']}).bindPopup(item['title']).addTo(map);
        });
      }, 
      "json"
      );

});



    </script>
  </body>
</html>