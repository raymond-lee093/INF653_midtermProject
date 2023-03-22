<?php
class Categories{
  // DB connection for categories table
  private $connection;
  private $table = "categories";

  // Category Properties
  public $id;
  public $category;

  // Constructor with DB
  public function __construct($db){
    $this->connection = $db;
  }

  // Read all categories
  public function read_all_categories(){
    $query = 'SELECT *
              FROM ' .$this->table. ' 
              ORDER BY id';
    // Prepare statement
    $stmt = $this->connection->prepare($query);
    // Execute query
    if($stmt->execute()){
      return $stmt;
    }
    return false;
  }

  // Read single category
  public function read_single(){
    $query = 'SELECT * 
              FROM ' .$this->table. '
              WHERE id = :id
              LIMIT 1';
              
    // Prepare statement 
    $stmt = $this->connection->prepare($query);
    // Bind parameter
    $stmt->bindParam(":id", $this->id);
    // Execute query
    $stmt->execute();
    // Fetch one associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Checks if row returns array
    if(is_array($row)){
      // Set properties
      $this->id = $row["id"];
      $this->category = $row["category"];
      return true;
    }
    return false;
  }

  // Create category
  public function create(){
    $query = 'INSERT INTO ' .$this->table. '(category)
              VALUES (:category)';
    // Prepare statement
    $stmt = $this->connection->prepare($query);
    // Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));
    // Bind parameter
    $stmt->bindParam(":category", $this->category);
    // Execute query
    if($stmt->execute()){
      return true;
    }
    return false;
    
  }

  // Update category
  public function update(){
    $query = 'UPDATE ' .$this->table.
              ' SET category = :category
              WHERE id = :id';
    // Prepare Statement
    $stmt = $this->connection->prepare($query);
    // Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind parameters
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":id", $this->id);
    // Execute query
    if($stmt->execute()){
      return true;
    }
    return false;
  }

  // Delete category
  public function delete(){
    $query = 'DELETE FROM ' .$this->table.
              ' WHERE id = :id';
    
    // Prepare statement
    $stmt = $this->connection->prepare($query);
    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind parameters
    $stmt->bindParam(":id", $this->id);
    // Execute query
    if($stmt->execute()){
      return true;
    }
    return false;
  }
}
?>