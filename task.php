<?php
class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $title;
    public $description;
    public $created_at;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM tasks WHERE user_id = :user_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      return $stmt;
  }

    public function create() {
      $query = "INSERT INTO " . $this->table_name . " (title, description, user_id) VALUES (:title, :description, :user_id)";
      $stmt = $this->conn->prepare($query);

      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));  // 
      $stmt->bindParam(":title", $this->title);
      $stmt->bindParam(":description", $this->description);
      $stmt->bindParam(":user_id", $this->user_id); 
  
      if($stmt->execute()) {
          return true;
      }
      return false;
  }
  


    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "SELECT id, title, description FROM tasks WHERE id = ? LIMIT 0,1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            $this->title = $row['title'];
            $this->description = $row['description'];
        }
    }

    public function update() {
        $query = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
}
?>
