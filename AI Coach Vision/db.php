<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'aicoach'); 

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['phone'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $username = $conn->real_escape_string($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $phone = $conn->real_escape_string($_POST['phone']);
        $sql = "INSERT INTO users (email, username, password, phone) VALUES ('$email', '$username', '$password', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('created successfully'); window.location.href='player/action/upload.php';</script>";
        } else {
            echo "<script>alert('something went wrong: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('يرجى تعبئة جميع الحقول.');</script>";
    }

    $conn->close();
}