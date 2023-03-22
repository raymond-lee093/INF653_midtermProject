<?php
	class Quotes{
    // DB connection for quotes table
		private $connection;
		private $table = "quotes";
		
    // Quote properties
		public $id;
		public $quote;
		public $author;
		public $category;
		public $author_id;
		public $category_id;
		
    // Constuctor with DB
		public function __construct($db) {
			$this->connection = $db;
		}
    
    // Read all quotes
    public function read_all_quotes(){
      $query = 'SELECT quotes.id, quotes.quote, authors.author, categories.category
              FROM ' .$this->table. '
              JOIN authors
              ON quotes.author_id = authors.id
              JOIN categories
              ON quotes.category_id = categories.id
              ORDER BY id';
      // Prepare statement
      $stmt = $this->connection->prepare($query);
      // Execute query
      if($stmt->execute()){
        return $stmt;
      }
      return false;
    }

    // Read single quote
    public function read_single(){
      // Id in quotes class recieved in GET method
      if (isset($_GET["id"])) {
        $query = 'SELECT quotes.id, quotes.quote, authors.author, categories.category
                  FROM ' .$this->table. '
                  JOIN authors
                  ON quotes.author_id = authors.id
                  JOIN categories
                  ON quotes.category_id = categories.id
                  WHERE quotes.id = :id
                  LIMIT 1';
        // Assign properties
        $this->id = $_GET["id"];
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
          $this->quote = $row["quote"];
          $this->author = $row["author"];
          $this->category = $row["category"];
          }
      }
      // Author id and category id received in GET method
      if(isset($_GET["author_id"]) && isset($_GET["category_id"])){
        $query = 'SELECT quotes.id, quotes.quote, authors.author, categories.category
                FROM ' .$this->table. '
                JOIN authors
                ON quotes.author_id = authors.id
                JOIN categories
                ON quotes.category_id = categories.id
                WHERE quotes.author_id = :author_id
                AND quotes.category_id = :category_id
                ORDER BY quotes.id';
        // Assign properties
        $this->author_id = $_GET["author_id"];
        $this->category_id = $_GET["category_id"];
        // Prepare statement 
        $stmt = $this->connection->prepare($query);
        // Bind parameter
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":category_id", $this->category_id);
        // Execute query
        if($stmt->execute()){
          return $stmt;
        }
        return false;
      }
      // Author id received in GET method
      if(isset($_GET["author_id"])) {
        $query = 'SELECT quotes.id, quotes.quote, authors.author, categories.category
                  FROM ' .$this->table. '
                  JOIN authors
                  ON quotes.author_id = authors.id
                  JOIN categories
                  ON quotes.category_id = categories.id
                  WHERE quotes.author_id = :author_id
                  ORDER BY quotes.id';
        // Assign properties
        $this->author_id = $_GET["author_id"];
        
        // Prepare statement 
        $stmt = $this->connection->prepare($query);
        // Bind parameter
        $stmt->bindParam(":author_id", $this->author_id);
        // Execute query
        if($stmt->execute()){
          return $stmt;
        }
        return false;
      }
      // Category id recieved in GET method
      if(isset($_GET["category_id"])) {
        $query = 'SELECT quotes.id, quotes.quote, authors.author, categories.category
                  FROM ' .$this->table. '
                  JOIN authors
                  ON quotes.author_id = authors.id
                  JOIN categories
                  ON quotes.category_id = categories.id
                  WHERE quotes.category_id = :category_id
                  ORDER BY quotes.id';
        // Assign properties
        $this->category_id = $_GET["category_id"];
        // Prepare statement 
        $stmt = $this->connection->prepare($query);
        // Bind parameter
        $stmt->bindParam(":category_id", $this->category_id);
        // Execute query
        if($stmt->execute()){
          return $stmt;
        }
        return false;
      }
    } 
    // Create quote
    public function create(){
      $query = 'INSERT INTO ' .$this->table. ' (quote, author_id, category_id)
                VALUES (:quote, :author_id, :category_id)';
      // Prepare statement
      $stmt = $this->connection->prepare($query);
      // Clean data
      $this->quote = htmlspecialchars(strip_tags($this->quote));
      $this->author_id = htmlspecialchars(strip_tags($this->author_id));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      // Bind parameter
      $stmt->bindParam(":quote", $this->quote);
      $stmt->bindParam(":author_id", $this->author_id);
      $stmt->bindParam(":category_id", $this->category_id);
      // Execute query
      if($stmt->execute()){
        $this->id = $this->connection->lastInsertId();
        return true;
      }
      return false;
    }
    // Update quote
    public function update(){
      $query = 'UPDATE ' .$this->table. '
                SET quote = :quote, 
                    author_id = :author_id, 
                    category_id = :category_id
                WHERE id = :id';
      // Prepare Statement
      $stmt = $this->connection->prepare($query);
      // Clean data
      $this->quote = htmlspecialchars(strip_tags($this->quote));
      $this->author_id = htmlspecialchars(strip_tags($this->author_id));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      $this->id = htmlspecialchars(strip_tags($this->id));
      // Bind parameters
      $stmt->bindParam(":quote", $this->quote);
      $stmt->bindParam(":author_id", $this->author_id);
      $stmt->bindParam(":category_id", $this->category_id);
      $stmt->bindParam(":id", $this->id);
      // Execute query
      if($stmt->execute()){
        // Fetch one associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Checks if row returns array
        if(is_array($row)){
          return true;
        }
      }
      return false;
    }

    // Delete quote
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
        // Fetch one associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Checks if row returns array
        if(is_array($row)){
          return true;
        }
      }
      return false;
    }
}
?>