<?php
session_start();

$_SESSION = array();

session_destroy();

session_start();
$_SESSION['success_message'] = "logged out successfully";
header("Location: ../pages/login.php");
exit();
?>
