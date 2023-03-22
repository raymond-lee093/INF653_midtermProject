<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Quote.php";
include_once "../../model/Author.php";
include_once "../../model/Category.php";
include_once "../../functions/isValid.php";


// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// Assign to properties
$quotes->id = $data->id;

// Delete row
if($quotes->delete()) {
  // Convert to JSON and output
  echo json_encode(array("id" => $quotes->id));
} 
else {
  echo json_encode(array("message" => "No Quotes Found"));
}
?>