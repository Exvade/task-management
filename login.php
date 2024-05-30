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

    if ($user->login()) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user->id;
        header("Location: dashboard.php");
    } else {
        $error_message = "Invalid Username or Password!";
    }
}
?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <?php if(!empty($error_message)) { echo $error_message; } ?>
</body>
</html>
