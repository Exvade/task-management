<?php
session_start();
include_once 'config.php';
include_once 'user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_POST) {
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];

    if ($user->register()) {
        echo "<script>alert('Registration successful. You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Username might be already taken.'); window.location.href='register.php';</script>";
    }
}
?>

<html>
<head>
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
