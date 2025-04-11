<?php
include('../../db.php');
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$checkEmail = "SELECT * FROM customers WHERE email = '$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    $_SESSION['error_message'] = 'Email already exists';
    header('Location: ../pages/register.php');
    return;
}

$checkPhoneNumber = "SELECT * FROM customers WHERE phoneNumber = '$phoneNumber'";
$result = $conn->query($checkPhoneNumber);

if ($result->num_rows > 0) {
    $_SESSION['error_message'] = 'Phone number already exists';
    header('Location: ../pages/register.php');
    return;
}

$otp = rand(100000, 999999);

$sql = "INSERT INTO customers (name, email, phoneNumber, password, otp) VALUES ('$name', '$email', '$phoneNumber', '$hashedPassword', '$otp')";
$result = $conn->query($sql);

if ($result === TRUE) {
    $id = $conn->insert_id;
    $_SESSION['id'] = $id;
    $_SESSION['phoneNumber'] = $phoneNumber;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = 'Customer';
    header('Location: ../pages/verify.php');
} else {
    $_SESSION['error_message'] = 'Error creating account';
    header('Location: ../pages/register.php');
}
?>
