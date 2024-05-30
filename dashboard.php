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
</head>
<body>
    <a href="logout.php" style="float:right; margin-right:20px;">Logout</a>
    <h1>Welcome to Your Task Management System</h1>

    <?php
    echo "<h2>Your Tasks</h2>";
    if ($num > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Title</th>";
        echo "<th>Description</th>";
        echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>";
            echo "<td>". ($id!== null? $id : ''). "</td>";
            echo "<td>". ($title!== null? $title : ''). "</td>";
            echo "<td>". ($description!== null? $description : ''). "</td>";
            echo "<td>";
            echo "<a href='edit_task.php?id={$id}'>Edit</a> | ";
            echo "<a href='delete_task.php?id={$id}'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No tasks found.";
    }
    ?>

    <h3>Add Task</h3>
    <form action="add_task.php" method="post">
        Title: <input type="text" name="title" required><br>
        Description: <textarea name="description" required></textarea><br>
        <input type="submit" value="Add Task">
    </form>
</body>
</html>
