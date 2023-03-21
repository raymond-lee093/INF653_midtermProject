<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../model/Author.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate author object
$authors = new Authors($db);

// Authors read_all_authors query
$result = $authors->read_all_authors();
// Get row count
$num_of_rows = $result->rowCount();

if($num_of_rows > 0){
  $author_array = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // Turn array keys into variable names
    extract($row);

    // Create associative array for each row
    $author_item = array(
      "id" => $id,
      "author" => $author
    );
    
    // Push each associative array into "data"
    array_push($author_array, $author_item);
  }

  // Convert to JSON and ouput
  echo json_encode($author_array);
}
else{
    echo json_encode(array("message" => "author_id Not Found"));
}
?>