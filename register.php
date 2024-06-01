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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center bg-gray-200" >

    <div class="flex w-[70%] h-[90%] flex-row-reverse">
    <div class="w-[50%] h-full bg-[url(./assets/login.png)]"></div>
    <div class="w-[50%] h-full bg-white flex flex-col justify-between">
      <img src="./assets/variasiKanan.jpg" alt="" class="w-[144px] aspect-square self-end">
      <div class="self-center h-[415px] w-[385px]">
        <div class="text-center">
          <h1 class="text-4xl font-medium tracking-wider">Sign Up</h1>
          <p class="text-2xl mt-2 font-normal">Get started absolutely free</p>
        </div>
        <form action="register.php" method="post" class="mt-[41px]">
          <label for="username" class="text-xl font-normal">Username</label>
          <br>
          <input type="text" name="username" id="username" required class="border-2 border-gray-300 rounded-md w-full h-[40px] p-2"><br>
          <br>
          <label for="password" class="mt-[20px] text-xl font-normal">Password</label>
          <br>
          <input type="password" name="password" id="password" required class="border-2 border-gray-300 rounded-md w-full h-[40px] p-2"><br>
          <p class="text-sm text-center mt-2 font-normal">Already have an account? <a href="login.php" class="text-blue-500">Sign In</a> </p>
          <input type="submit" value="Sign Up" class="w-full bg-[#03A9F4] mt-4 h-[34px] font-medium text-white rounded-md">
      </form>
      </div>
      <img src="./assets/variasiKiri.jpg" alt="" class="w-[144px] aspect-square">
    </div>
  </div>
</body>
</html>
