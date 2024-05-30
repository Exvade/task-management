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
$task->id = $_GET['id'];

if ($task->delete()) {
    echo "<script>alert('Task was deleted.'); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('Unable to delete task.'); window.location.href='dashboard.php';</script>";
}
?>
