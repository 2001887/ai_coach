<?php
include('../db.php');
session_start();

$name = $_POST['name'];
echo "\$name "; print_r($name); echo "\n";
$email = $_POST['email'];
echo "\$email "; print_r($email); echo "\n";
$phoneNumber = $_POST['phoneNumber'];
$password = $_POST['password'];
echo "\$password "; print_r($password); echo "\n";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "\$hashedPassword "; print_r($hashedPassword); echo "\n";

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
    $_SESSION['customer_id'] = $id;
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
