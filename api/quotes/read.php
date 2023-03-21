<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../model/Quote.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Quotes read_all_quotes query
$result = $quotes->read_all_quotes();
// Get row count
$num_of_rows = $result->rowCount();

if($num_of_rows > 0){
  $quote_array = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    // Turn array keys into variable names
    extract($row);
    // Create associative array for each row
    $quote_item = array(
      "id" => $id,
      "quote" => $quote,
      "author" => $author,
      "category" => $category
    );
    // Push each associative array into "data"
    array_push($quote_array, $quote_item);
  }
  // Convert to JSON and ouput
  echo json_encode($quote_array);
}
else{
    echo json_encode(array("message" => "No Quotes Found"));
}
?>