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
<body>
    <a href="dashboard.php" style="float:right; margin-right:20px;">Back to Dashboard</a>
    <h1>Edit Task</h1>
    <form action="<?php echo htmlspecialchars("edit_task.php?id=" . $task->id); ?>" method="post">
        Title: <input type="text" name="title" value="<?php echo $task->title; ?>" required><br>
        Description: <textarea name="description" required><?php echo $task->description; ?></textarea><br>
        <input type="submit" value="Update Task">
    </form>
</body>
</html>
