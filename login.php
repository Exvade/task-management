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
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center items-center bg-gray-200">
  <div class="flex w-[70%] h-[90%]">
    <div class="w-[50%] h-full bg-[url(./assets/login.png)]"></div>
    <div class="w-[50%] h-full bg-white flex flex-col justify-between">
      <img src="./assets/variasiKanan.jpg" alt="" class="w-[144px] aspect-square self-end">
      <div class="self-center h-[415px] w-[385px]">
        <div class="text-center">
          <h1 class="text-4xl font-medium tracking-wider">Sign In</h1>
          <p class="text-2xl mt-2 font-normal">Get started absolutely free</p>
        </div>
        <form action="login.php" method="post" class="mt-[41px]">
          <label for="username" class="text-xl font-normal">Username</label>
          <br>
          <input type="text" name="username" id="username" required class="border-2 border-gray-300 rounded-md w-full h-[40px] p-2"><br>
          <br>
          <label for="password" class="mt-[20px] text-xl font-normal">Password</label>
          <br>
          <input type="password" name="password" id="password" required class="border-2 border-gray-300 rounded-md w-full h-[40px] p-2"><br>
          <p class="text-sm text-center mt-2 font-normal">Don't have an account? <a href="register.php" class="text-blue-500">Sign up</a> </p>
          <input type="submit" value="Sign In" class="w-full bg-[#03A9F4] mt-4 h-[34px] font-medium text-white rounded-md">
      </form>
      <?php if (!empty($error_message)) {
        echo $error_message;
      } ?>
      </div>
      <img src="./assets/variasiKiri.jpg" alt="" class="w-[144px] aspect-square">
    </div>
  </div>
</body>

</html>