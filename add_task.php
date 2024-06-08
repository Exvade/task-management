<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include_once 'config.php';
include_once 'task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

if ($_POST) {
  $task->title = $_POST['title'];
  $task->description = $_POST['description'];
  $task->user_id = $_SESSION['user_id'];

  if ($task->create()) {
      echo "<script>alert('Task added successfully.'); window.location.href='dashboard.php';</script>";
  } else {
      echo "<script>alert('Unable to add task.'); window.location.href='dashboard.php';</script>";
  }
}

?>
