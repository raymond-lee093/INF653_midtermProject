<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
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

// Assign to properties
$authors->id = $data->id;

// Delete author
if($authors->delete()) {
  // Convert to JSON and output
  echo json_encode(array("id" => $authors->id));
} 
else {
  echo json_encode(array("message" => "author_id Not Found"));
}
?>