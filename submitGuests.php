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

     $name = $data['name'];
     $num_guests = $data['numGuests'];
     $comments = $data['comments'];
     $id = $data['id'];

     $query = 'insert into registered_guests (ID, name, guest_num, comments, timestamp) values ("' . $id . '", "' . $name . '", "' . $num_guests .'", "'. $comments .'", "'.  date("Y-m-d H:i:s") .'");';
     mysqli_query($conn, $query);

     if(mysqli_error($conn))
       {
           $obj = (object) [
                            "error" => mysqli_error($conn)
                            ];
           //echo("Error description: " . mysqli_error($con));
           echo json_encode($obj);
       } else {

            $query = 'select * from registered_guests where ID=' . $id . ' order by timestamp desc LIMIT 1';
            $res = mysqli_query($conn, $query);

             $results = [];
                     while( $row = $res->fetch_assoc() ){
                             $obj = (object) [
                                                       "name" => $row['name'],
                                                       "num_guests" => $row['guest_num'],
                                                       "comments" => $row['comments']
                                                       ];
                            array_push($results, $obj);
                     }
                     echo json_encode($results);
       }
  }

?>