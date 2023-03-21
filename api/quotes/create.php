<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
$quotes->id = $data->id;
$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

// Checks if category id exists
$categories = new Categories($db);
$categories->id = $quotes->category_id;
$categoryExists = isValid($categories->id, $categories);
// If it doesn't exist
if(!$categoryExists){
  echo json_encode(array("message" => "category_id Not Found"));
  exit();
}

// Checks if author id exists
$authors = new Authors($db);
$authors->id = $quotes->author_id;
$authorExists = isValid($authors->id, $authors);
// If it doesn't exist
if(!$authorExists){
  echo json_encode(array("message" => "author_id Not Found"));
  exit();
}

if($quotes->create()) {
  // Convert to JSON and output
  echo json_encode(array("id" => $quotes_id, "quote" => $quotes->quote, "author_id" => $quotes->author_id, "category_id" => $quotes->category_id));
} 
else {
  echo json_encode(array("message" => "No Quotes Found"));
}
?>