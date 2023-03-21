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

// Categories read_all_categories query
$result = $categories->read_all_categories();
// Get row count
$num_of_rows = $result->rowCount();

if($num_of_rows > 0){
  $category_array = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // Turn array keys into variable names
    extract($row);

    // Create associative array for each row
    $category_item = array(
      "id" => $id,
      "category" => $category
    );
    
    // Push each associative array into "data"
    array_push($category_array, $category_item);
  }

  // Convert to JSON and ouput
  echo json_encode($category_array);
}
else{
    echo json_encode(array("message" => "category_id Not Found"));
}
?>