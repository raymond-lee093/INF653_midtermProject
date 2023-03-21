<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../config/Database.php";
include_once "../../model/Category.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate category object
$categories = new Categories($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// If data poperty does not have a value
if(!isset($data->category)){
  echo json_encode(array("message" => "Missing Required Parameters"));
  exit();
}

// Assign to properties
$categories->category = $data->category;

// If create method is successful
if($categories->create()){
  // Convert to JSON and output
  echo json_encode(array("id" => $categories->id, "category" => $categories->category));
}
else{
  echo json_encode(array("message" => "category_id Not Found"));
}
?>