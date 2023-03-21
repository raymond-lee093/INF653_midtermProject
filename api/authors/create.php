<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Author.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate author object
$authors = new Authors($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// If data poperty does not have a value
if(!isset($data->author)){
  echo json_encode(array("message" => "Missing Required Parameters"));
  exit();
}

// Assign to properties
$authors->author = $data->author;

// If create method is successful
if($authors->create()){
  // Convert to JSON and output
  echo json_encode(array("id" => $authors->id, "author" => $authors->author));
}
else{
  echo json_encode(array("message" => "author_id Not Found"));
}
?>