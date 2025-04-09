<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verification Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="verification-container">
        <img src="logo-removebg-preview.png" alt="AI COACH logo" class="logo">
        <h2>Enter The Verification Code Sent To Your Mobile Number</h2>
        <form>
            <div class="input-group">
                <input type="text" id="verification-code" name="verification-code" placeholder="Enter Code" required>
            </div>
            <button type="submit" class="verify-btn">Verify</button>
        </form>
        <p class="resend-text">Don't Receive the Verify Code? <a href="#">Send it again</a></p>
    </div>
</body>
</html>
<style>
    body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
}

.verification-container {
    width: 400px;
    text-align: center;
    background:none;
    margin-top: 100px;
    margin-bottom: 196px;
    border:none;
    box-shadow:none;
    position: relative;
    top: -100px;
}

.logo {
    width: 500px;
    height: auto;
    margin: 0 auto -106px -63px;
    position: relative;
    z-index: 1;
}


h2 {
    color: #005f73;
    margin-bottom: 35px;
    font-size: 13px;
}

.input-group input {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 13px;
}

.verify-btn {
    width: 100%;
    padding: 12px;
    background-color: #007b83;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.verify-btn:hover {
    background-color: #005f73;
}

.resend-text {
    margin-top: 15px;
    font-size: 14px;
    color: #005f73;
}

.resend-text a {
    color: rgba(98, 106, 160, 1);
    text-decoration: none;
}

.resend-text a:hover {
    text-decoration: underline;
}
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'ai_coach');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Login Successful!'); window.location.href='dashboard.html';</script>";
        } else {
            echo "<script>alert('Incorrect Password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Username not found'); window.location.href='login.html';</script>";
    }
    $conn->close();
}
?>