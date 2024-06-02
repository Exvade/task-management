<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

include_once 'config.php';
include_once 'task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$task->user_id = $_SESSION['user_id']; // Menggunakan user_id dari session
$stmt = $task->read();
$num = $stmt->rowCount();
?>

<html>

<head>
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url(./assets/gapura.jpg)] bg-no-repeat bg-cover bg-center min-h-screen w-full flex justify-center items-center flex-col">
  <a href="logout.php" class="mr-[20px] absolute px-4 py-2 bg-blue-400 right-0 top-0 mt-[20px] text-1xl font-medium rounded-md text-white">Logout</a>
  <h1 class="px-4 py-2 text-3xl font-bold text-blue-500 bg-white -mt-[300px] rounded-md">Welcome to Your Task Management System</h1>
  <div class="w-[600px] bg-red-400 mt-20">

    <?php
    echo "<h2 class='text-2xl'>Your Tasks</h2>";
    if ($num > 0) {
      echo "<ol>";  // Menggunakan ordered list untuk menampilkan tasks
      $counter = 1; // Variabel untuk nomor urut
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<li>";
        echo "<div><strong>Task $counter</strong></div>";  // Menampilkan nomor urut task
        echo "<div>Title: " . ($title !== null ? $title : '') . "</div>";
        echo "<div>Description: " . ($description !== null ? $description : '') . "</div>";
        echo "<div>" . ($id !== null ? $id : '') . "</div>";
        echo "<div><a href='edit_task.php?id={$id}'>Edit</a> | <a href='delete_task.php?id={$id}'>Delete</a></div>";
        echo "</li>";
        $counter++;  // Menambahkan counter setiap iterasi
      }
      echo "</ol>";
    } else {
      echo "No tasks found.";
    }
    ?>

    <h3>Add Task</h3>
    <form action="add_task.php" method="post">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" required><br>
      <label for="description">Description</label> 
      <textarea name="description" id="description" required></textarea><br>
      <input type="submit" value="Add Task">
    </form>
  </div>
</body>

</html>