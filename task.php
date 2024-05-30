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

    // Metode untuk membaca semua tugas
    public function read() {
      $query = "SELECT * FROM tasks WHERE user_id = :user_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      return $stmt;
  }

    // Metode untuk menambah tugas baru
    public function create() {
      // Menambahkan user_id dalam SQL query
      $query = "INSERT INTO " . $this->table_name . " (title, description, user_id) VALUES (:title, :description, :user_id)";
      $stmt = $this->conn->prepare($query);
  
      // Membersihkan data
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));  // Pastikan user_id juga dibersihkan
  
      // Mengikat data
      $stmt->bindParam(":title", $this->title);
      $stmt->bindParam(":description", $this->description);
      $stmt->bindParam(":user_id", $this->user_id);  // Mengikat user_id ke query
  
      if($stmt->execute()) {
          return true;
      }
      return false;
  }
  

    // Metode untuk menghapus tugas
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
}
?>
