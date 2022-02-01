<?php


$servername = "mysqlcluster11.registeredsite.com";
$username = "frcc";
$password = "FrontRangeCWB208";
$dbname = "frcc";



function get_points(){
  global $servername, $username, $password, $dbname;
  // Create connection
  $mysqli = new mysqli($servername, $username, $password, $dbname );

  $bounds = json_decode( $_POST['bounds']);
  $min_lat = min($bounds[0],$bounds[2]);
  $max_lat = max($bounds[0],$bounds[2]);
  $min_long = min($bounds[1],$bounds[3]);
  $max_long = max($bounds[1],$bounds[3]);

  $sql = "SELECT 
    *
  FROM 
    bfro_locations bl 
  where
    latitude > {$min_lat}
    and latitude < {$max_lat}
    and longitude > {$min_long}
    and longitude < {$max_long}
  limit 300
  ";
  $result = $mysqli->query( $sql);


  $rows = array();
  while($r = $result->fetch_assoc()) {
      $rows[] = $r;
    }

  $mysqli->close();
  $json = json_encode( $rows );
  return $json;  
}

switch($_GET['method']) {
case 'get_points':
    echo get_points();
}
?>