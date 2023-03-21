<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../model/Author.php";

// Instantiate DB connection
$database = new Database();
$db = $database->connect();

// Instantiate author object
$authors = new Authors($db);

// Get id
$authors->id = isset($_GET["id"]) ? $_GET["id"] : die();
// Get author
$authors->read_single();

if($authors->author !== null){
  $authors_array = array(
    "id" => $authors->id,
    "author" => $authors->author
  );

  //Convert to JSON and output
  echo json_encode($authors_array);
}
else{
    echo json_encode(array("message" => "author_id Not Found"));
}
?>