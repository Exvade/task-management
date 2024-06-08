<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
      $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
      $stmt = $this->conn->prepare($query);
  
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
  
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);
  
      if ($stmt->execute()) {
          return true;
      }
      return false;
  }
  

    public function login() {
      $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";
      $stmt = $this->conn->prepare($query);
  
      $this->username = htmlspecialchars(strip_tags($this->username));
      $stmt->bindParam(':username', $this->username);
      $stmt->execute();
      $num = $stmt->rowCount();
  
      if ($num > 0) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $this->id = $row['id'];
          $this->username = $row['username'];
  
        
          if (password_verify($this->password, $row['password'])) {
              return true;
          }
      }
      return false;
  }
  
}
?>
