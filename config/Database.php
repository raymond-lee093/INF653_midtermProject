<?php
class Database {
  // DB Params
  private $host;
  private $db_name;
  private $username;
  private $password;
  private $connection;
  private $port;
  // Constructor
  public function __construct(){
    $this->username = getenv("USERNAME");
    $this->password = getenv("PASSWORD");
    $this->db_name = getenv("DBNAME");
    $this->host = getenv("HOST");
    $this->port = getenv("PORT");
  } 
  // DB Connect
  public function connect() {
    if ($this->connection){ 
      return $this->connection = null;
    }
    else{
      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
      try { 
        $this->connection = new PDO($dsn, $this->username, $this->password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
      catch(PDOException $error) {
          echo 'Connection Error: ' . $error->getMessage();
      }
    }
      return $this->connection;
    }
}
?>