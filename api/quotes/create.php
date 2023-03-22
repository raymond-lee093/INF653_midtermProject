<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Quote.php";
include_once "../../model/Category.php";
include_once "../../model/Author.php";
include_once "../../functions/isValid.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
  echo json_encode(array('message' => 'Missing Required Parameters'));
  exit();
}

// Assign to properties
$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

// Checks if category id exists
$categoryid_in_db = new Categories($db);
$categoryExists = isValid($quotes->category_id, $categoryid_in_db);
// If it doesn't exist
if(!$categoryExists){
  echo json_encode(array("message" => "category_id Not Found"));
  exit();
}

// Checks if author id exists
$authorid_in_db = new Authors($db);
$authorExists = isValid($quotes->author_id, $authorid_in_db);
// If it doesn't exist
if(!$authorExists){
  echo json_encode(array("message" => "author_id Not Found"));
  exit();
}

if($quotes->create()) {
  // Convert to JSON and output
  echo json_encode(array("id" => $quotes->id, "quote" => $quotes->quote, "author_id" => $quotes->author_id, "category_id" => $quotes->category_id));
} 
else {
  echo json_encode(array("message" => "No Quotes Found"));
}
?>