<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Quote.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// Assign to properties
$quotes->id = $data->id;
// Delete quote
$result = $quotes->delete();
// Get row count
$num_of_rows = $result->rowCount();

// If num_of_rows > 0, a row was deleted, otherwise no row deleted
if($num_of_rows > 0 ) {
  // Convert to JSON and output
  echo json_encode(array("id" => $quotes->id));
} 
else {
  echo json_encode(array("message" => "No Quotes Found"));
}
?>