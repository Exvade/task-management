<?php
class Database {
  private $host = "localhost";
  private $db_name = "nama_database";
  private $username = "username_db";
  private $password = "password_db";
  public $conn;

  public function getConnection() {
      $this->conn = null;
      try {
          $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
          $this->conn->exec("set names utf8");
      } catch (PDOException $exception) {
          echo "Connection error: " . $exception->getMessage();
          return null;  // Pastikan untuk menambahkan ini jika ada exception
      }
      return $this->conn;  // Pastikan fungsi ini mengembalikan objek PDO
  }
}

?>
