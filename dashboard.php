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
  <style>
    .no-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.no-scrollbar::-webkit-scrollbar-track {
  background: #60a5fa;
}
.no-scrollbar::-webkit-scrollbar-thumb {
  background: white;
}
  </style>
</head>

<body class="bg-[url(./assets/gapura.jpg)] bg-no-repeat bg-cover bg-center min-h-screen w-full flex justify-center items-center flex-col">
  <a href="logout.php" class="mr-[20px] absolute px-4 py-2 bg-blue-400 right-0 top-0 mt-[20px] text-1xl font-medium rounded-md text-white">Logout</a>
  <h1 class="px-4 py-2 text-3xl font-bold text-blue-500 bg-white rounded-md">Welcome to Your Task Management System</h1>
  <div class="w-[1000px] mt-1 0">
    <?php
    echo "<h2 class='px-4 py-2 mt-5 mb-4 text-2xl font-semibold text-white bg-black rounded-md bg-opacity-40'>Your Tasks</h2>";
    if ($num > 0) {
      echo "<ol class='flex flex-col w-full gap-6 py-8 text-white bg-black bg-opacity-40 h-[300px] overflow-y-scroll rounded-md no-scrollbar'>"; 
      $counter = 1;
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        echo "<li class='flex justify-around gap-10 text-xl'>";
        echo "<div class='w-4'><strong>$counter</strong></div>";  // Menampilkan nomor urut task
        echo "<div class='hidden'>" . ($id !== null ? $id : '') . "</div>";
        echo "<div class='w-[200px]'>" . ($title !== null ? $title : '') . "</div>";
        echo "<div class='w-[300px]'>" . ($description !== null ? $description : '') . "</div>";
        echo "<div class='flex gap-2'><a href='edit_task.php?id={$id}' class='w-[100px] h-[40px] text-black bg-yellow-500 rounded-md text-center flex items-center justify-center'>Edit</a><a href='delete_task.php?id={$id}' class='w-[100px] h-[40px] bg-red-500 text-center flex items-center justify-center rounded-md'>Delete</a></div>";
        echo "</li>";
        $counter++;  // Menambahkan counter setiap iterasi
      }
      echo "</ol>";
    } else {
      echo "<h3 class='w-full py-4 text-2xl font-semibold text-center text-white bg-black bg-opacity-40'>No tasks found.</h3>";
    }
    ?>

    

  <form class="max-w-md p-4 mx-auto mt-10 bg-black rounded-md bg-opacity-40" action="add_task.php" method="post">
    <h1 class="text-2xl font-semibold text-center text-white">Add Task</h1>
    <div class="mb-5">
      <label for="title" class="block mb-2 text-sm font-medium text-white dark:text-white">Title</label>
      <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Play Valorant" required />
    </div>
    <div class="mb-5">
      <label for="description" class="block mb-2 text-sm font-medium text-white dark:text-white">Description</label>
      <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-wrap h-[70px]" placeholder="Playing with friends and with 'No Radiant No Sleep' Mentality" required></textarea>
    </div>
    <button type="submit" class="px-6 py-3 text-sm font-medium text-center text-white bg-blue-400 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 sm:w-auto">Add</button>
  </form>

  </div>
</body>

</html>