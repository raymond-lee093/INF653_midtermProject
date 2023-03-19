<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/database.php";
include_once "../../model/author.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate author object
$authors = new Authors($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// If data poperty does not have a value
if(!isset($data->author)){
  echo json_encode(array("Message" => "Missing Required Parameters."));
  exit();
}

// Assign to properties
$authors->id = $data->id;
$authors->author = $data->author;

// Update author
$result = $authors->update();
// Get row count
$num_of_rows = $result->rowCount();

// If num_of_rows > 0, a row was update, otherwise no row wasn't updated
if($num_of_rows > 0 ) {
  // Convert to JSON and output
  echo json_encode(array("id" => $authors->id, "author" => $authors->author));
} 
else {
  echo json_encode(array("Message" => "author_id Not Found."));
}
?>