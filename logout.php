<?php
session_start();
// Menghancurkan semua session
session_destroy();

// Mengarahkan kembali ke halaman login
header("Location: login.php");
exit;
?>
