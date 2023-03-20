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

// Id in quotes class recieved in GET method
if(isset($_GET["id"])){
  // Get id
  $quotes->id = isset($_GET["id"]) ? $_GET["id"] : die();
  // Get quote
  $quotes->read_single();

  if($quotes->quote !== null){
    $quote_array = array();
    $quote_array["data"] = array();
    $quote_item = array(
      "id" => $quotes->id,
      "quote" => $quotes->quote,
      "author" => $quotes->author,
      "category" => $quotes->category
    );
    // Push each associative array into "data"
    array_push($quote_array["data"], $quote_item);
    //Convert to JSON and output
    echo json_encode($quote_array);
  }
  else{
    echo json_encode(array("Message" => "Quote Not Found."));
  }
}

// Author id and category id received in GET method
if(isset($_GET["author_id"]) && isset($_GET["category_id"])){
  // Get ids
  $quotes->author_id = isset($_GET["author_id"]) ? $_GET["author_id"] : die();
  $quotes->category_id = isset($_GET["category_id"]) ? $_GET["category_id"] : die();

  // Get quote
  $result = $quotes->read_single();
  // Get row count
  $num_of_rows = $result->rowCount();
  
  if($num_of_rows > 0){
    $quote_array = array();
    $quote_array["data"] = array();
  
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
      array_push($quote_array["data"], $quote_item);
      }
    // Convert to JSON and ouput
    echo json_encode($quote_array);
    }
    else{
      echo json_encode(array("Message" => "No Quotes Found."));
    }
}

// Author id received in GET method
if(isset($_GET["author_id"]) && !isset($_GET["category_id"])){
  // Get id
  $quotes->author_id = isset($_GET["author_id"]) ? $_GET["author_id"] : die();
  // Get quote
  $result = $quotes->read_single();
  // Get row count
  $num_of_rows = $result->rowCount();

  if($num_of_rows > 0){
    $quote_array = array();
    $quote_array["data"] = array();

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
      array_push($quote_array["data"], $quote_item);
    }
    // Convert to JSON and ouput
    echo json_encode($quote_array);
  }
  else{
    echo json_encode(array("Message" => "No Quotes Found."));
  }
}

// Category id recieved in GET method
if(isset($_GET["category_id"]) && !isset($_GET["author_id"])){
  // Get id
  $quotes->author_id = isset($_GET["category_id"]) ? $_GET["category_id"] : die();
  // Get quote
  $result = $quotes->read_single();
  // Get row count
  $num_of_rows = $result->rowCount();

  if($num_of_rows > 0){
    $quote_array = array();
    $quote_array["data"] = array();

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
      array_push($quote_array["data"], $quote_item);
    }
    // Convert to JSON and ouput
    echo json_encode($quote_array);
  }
  else{
    echo json_encode(array("Message" => "No Quotes Found."));
  }
}
?>