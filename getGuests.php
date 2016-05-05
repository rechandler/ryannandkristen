<?php

header('Accept-Charset: utf-8');
header('Content-Type: application/x-www-form-urlencoded,');

$servername = "107.180.57.160";
$username = "ryann";
$password = "Gooch123!";
$dbname = "wedding_guests";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  else{

         $query = 'SELECT name, guest_num, comments, ID, timestamp FROM `registered_guests` WHERE timestamp in (select max(timestamp) from registered_guests group by ID) group by timestamp, ID order by ID asc';
         $res = mysqli_query($conn, $query);

         $results = [];
         while( $row = $res->fetch_assoc() ){
                $obj = (object) [
                "id" => $row['ID'],
                "name" => $row['name'],
                "comments" => $row['comments'],
                "num_guests" => $row['guest_num'],
                "timestamp" => $row['timestamp']
                ];
                array_push($results, $obj);
         }
         echo json_encode($results);
  }

?>