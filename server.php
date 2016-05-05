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
     $data = json_decode(file_get_contents('php://input'), true);

     $code = $data["data"];
         $query = 'select * from guests where reg_code = "'.$code . '"';
         $res = mysqli_query($conn, $query);

         $results = [];
         while( $row = $res->fetch_assoc() ){
                $obj = (object) [
                "id" => $row['ID'],
                "firstName" => $row['firstName'],
                "lastName" => $row['lastName'],
                "address" => $row['address'],
                "name" => $row['name'],
                "num_guests" => $row['num_guests']
                ];
                array_push($results, $obj);
         }
         echo json_encode($results);
  }

?>