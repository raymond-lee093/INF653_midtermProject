<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../model/Category.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate category object
$categories = new Categories($db);

// Get id
$categories->id = isset($_GET["id"]) ? $_GET["id"] : die();
// Get category
$categories->read_single();

if($categories->category !== null){
  $categories_array = array(
    "id" => $categories->id,
    "category" => $categories->category
  );
  //Convert to JSON and output
  echo json_encode($categories_array);
}
else{
    echo json_encode(array("message" => "category_id Not Found"));
}
?>