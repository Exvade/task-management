<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Memastikan ID tugas disediakan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php"); // Arahkan kembali ke dashboard jika ID tidak valid
    exit;
}

include_once 'config.php';
include_once 'task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$task->id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengupdate tugas
    $task->title = $_POST['title'];
    $task->description = $_POST['description'];


    if ($task->update()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p>Unable to update task. Please try again.</p>";
    }
} else {
    // Mengambil data tugas untuk diisi ke dalam formulir
    $task->readOne();
}

?>

<html>
<head>
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[url(./assets/gapura.jpg)] bg-no-repeat bg-cover bg-center min-h-screen w-full flex justify-center items-center flex-col">
    <a href="dashboard.php" class="mr-[20px] absolute px-4 py-2 bg-blue-400 right-0 top-0 mt-[20px] text-1xl font-medium rounded-md text-white">Back to Dashboard</a>
    <form class="w-[600px] p-4 mx-auto mt-10 bg-black rounded-md bg-opacity-40" action="<?php echo htmlspecialchars("edit_task.php?id=" . $task->id); ?>" method="post">
    <h1 class="text-2xl font-semibold text-center text-white">Edit Task</h1>
    <div class="mb-5">
      <label for="title" class="block mb-2 text-sm font-medium text-white dark:text-white">Title</label>
      <input type="text" name="title" value="<?php echo $task->title; ?>" id="title" class="bg-gray-50 border border-gray-300 text-gray-900  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    </div>
    <div class="mb-5">
      <label for="description" class="block mb-2 text-sm font-medium text-white dark:text-white">Description</label>
      <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-wrap h-[70px]" required><?php echo $task->description; ?></textarea>
    </div>
    <button type="submit" class="px-6 py-3 text-sm font-medium text-center text-black bg-yellow-500 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-blue-300 sm:w-auto">Edit</button>
  </form>
</body>
</html>
