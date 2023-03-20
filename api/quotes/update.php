<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Quote.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate quotes object
$quotes = new Quotes($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)||!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
  echo json_encode(array('Message' => 'Missing Required Parameters'));
  exit();
}
// Assign to properties
$quotes->id = $data->id;
$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

// Update quote
$result = $quotes->update();
// Get row count
$num_of_rows = $result->rowCount();

// If num_of_rows > 0, a row was update, otherwise no row wasn't updated
if($num_of_rows > 0 ) {
  // Convert to JSON and output
  echo json_encode(array("id" => $quotes->id, "quote" => $quotes->quote, 
                        "author_id" => $quotes->author_id, "category_id" => $quotes->category_id));
} 
else {
  echo json_encode(array("Message" => "No Quotes Found."));
}
?>