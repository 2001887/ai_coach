<?php
include('../../db.php');
session_start();

$email = $_POST['email'];
echo "\$email "; print_r($email); echo "\n";
$password = $_POST['password'];
echo "\$password "; print_r($password); echo "\n";
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
echo "\$hashedPassword "; print_r($hashedPassword); echo "\n";

$sql = "SELECT * FROM customers WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    if(password_verify($password, $row['password'])) {
        // Password is correct, set session variables
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = 'Customer';
        $_SESSION['name'] = $row['name'];
        $_SESSION['phoneNumber'] = $row['phoneNumber'];

        $phoneVerified = $row['phoneVerified'];

        if($phoneVerified == 'no') {
            $_SESSION['success_message'] = "logged in successfully!";
            $otp = rand(100000, 999999);
            $sql = "UPDATE customers SET otp = '$otp' WHERE email = '$email'";
            $result = $conn->query($sql);
            header('Location: ../pages/verify.php');
            exit();
        }

        $_SESSION['success_message'] = "logged in successfully!";
        header("Location: ../pages/upload.php");

        exit();
    } else {
        echo "Incorrect password!";
        $_SESSION['error_message'] =  "Invalid email or password";
        header("Location: login.php");

    }

   
} else {
    // echo "Invalid email or password";
    $_SESSION['error_message'] = 'Invalid email or password';
    header('Location: ../pages/login.php');
}