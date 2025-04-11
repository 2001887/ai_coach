<?php 
include('../../db.php');
session_start();
$email = $_SESSION['email'];
$otp = $_POST['otp'];

$sql = "SELECT * FROM customers WHERE email = '$email' AND otp = '$otp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sql = "UPDATE customers SET phoneVerified = 'yes' WHERE email = '$email'";
    $result = $conn->query($sql);
    $_SESSION['success_message'] = 'Phone verified successfully';
    header('Location: ../pages/upload.php');
} else {
    $_SESSION['error_message'] = 'Invalid OTP';
    header('Location: ../pages/verify.php');
}

?>