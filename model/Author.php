<?php
class Authors{
  // DB connection for authors table
  private $connection;
  private $table = "authors";

  // Author Properties
  public $id;
  public $author;

  // Constructor with DB
  public function __construct($db){
    $this->connection = $db;
  }

  // Read all authors 
  public function read_all_authors(){
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

  // Read single author
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
      $this->author = $row["author"];
      return true;
    }
    return false;
  }

  // Create author
  public function create(){
    $query = 'INSERT INTO ' .$this->table. '(author)
              VALUES (:author)';
    // Prepare statement
    $stmt = $this->connection->prepare($query);
    // Clean data
    $this->author = htmlspecialchars(strip_tags($this->author));
    // Bind parameter
    $stmt->bindParam(":author", $this->author);
    // Execute query
    if($stmt->execute()){
      return true;
    }
    return false;
  }

  // Update author
  public function update(){
    $query = 'UPDATE ' .$this->table.
              ' SET author = :author
              WHERE id = :id';
    // Prepare Statement
    $stmt = $this->connection->prepare($query);
    // Clean data
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind parameters
    $stmt->bindParam(":author", $this->author);
    $stmt->bindParam(":id", $this->id);
    // Execute query
    if($stmt->execute()){
      return true;
    }
    return false;
  }

  // Delete author
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