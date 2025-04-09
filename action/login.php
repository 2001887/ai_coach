<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="login-container">
        <img src="logo-removebg-preview.png" alt="AI COACH logo" class="logo">
        <h2>Log In</h2>
        <form>
            <div class="input-group">
                <label for="username">UserName</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Log In</button>
        </form>
        <p class="signup-text">Don't have an account? <a href="/AI%20Coach%20Vision/player/action/singup.php">Create New account</a></p>
    </div>
    </body>
</html>
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #ffff;
    font-family: Arial, sans-serif;
}

.login-container {
    width: 400px;
    background:none;
    margin-top: 100px;
    margin-bottom: 196px;
    border:none;
    box-shadow: none;
    text-align: center; 
    position: relative;
    top:-100px;   
}

.logo {
    width: 500px;
    height: auto;
    margin: 0 auto -106px -57px;
    position: relative;
    z-index: 1;
}

h2 {
    color: #005f73;
    margin-bottom: 20px;
}

.input-group {
    padding: 12px;
    text-align: left;
    margin-bottom: 15px;
    border-radius: 5px;   
}

.input-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    color: #005f73;
}

.input-group input {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    
}

.login-btn {
    width: 100%;
    background-color: #007b83;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.login-btn:hover {
    background-color: #005f73;
}

.signup-text {
    margin-top: 15px;
    font-size: 14px;
    color: #005f73;
}

.signup-text a {
    color: rgba(98, 106, 160, 1);
    text-decoration: none;
}

.signup-text a:hover {
    text-decoration: underline;
}
</style>
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
            echo "<script>alert('Login Successful!'); window.location.href='player/action/upload.php';</script>";
        } else {
            echo "<script>alert('Incorrect Password'); window.location.href='player/action/login.php';</script>";
        }
    } else {
        echo "<script>alert('Username not found'); window.location.href='player/action/login.php';</script>";
    }
    $conn->close();
}
?>