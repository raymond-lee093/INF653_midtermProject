<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Author.php";
include_once "../../functions/isValid.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate author object
$authors = new Authors($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// If data poperty does not have a value
if(!isset($data->id)||!isset($data->author)){
  echo json_encode(array("message" => "Missing Required Parameters"));
  exit();
}

// Assign to properties
$authors->id = $data->id;
$authors->author = $data->author;

// Checks if author id exists
$authorid_in_db = new Authors($db);
$authorExists = isValid($authors->id, $authorid_in_db);
// If it doesn't exist
if(!$authorExists){
  echo json_encode(array("message" => "author_id Not Found"));
  exit();
}

// Update author
if($authors->update()) {
  // Convert to JSON and output
  echo json_encode(array("id" => $authors->id, "author" => $authors->author));
} 
else {
  echo json_encode(array("Message" => "author_id Not Found."));
}
?>