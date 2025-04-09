
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
?>
<!DOCTYPE html>
<html lang="en">
  <!DOCTYPE html>
  <html>
  <link rel="stylesheet" href="style.css">
    <title>singup</title>
 <body>
<div class="login-container">
  <img src="logo-removebg-preview.png" alt="AI COACH logo" class="logo">
  <h2>Create New Account</h2>
  <form>

 <div class="input-group">
 <label for="Email">Email</label>
 <input type="email" id="email" name="email" required>
 </div>

<div class="input-group">
 <label for="Username">Username</label>
 <input type="Username" id="Username" name="Username" required>
 </div>


 <div class="input-group">
  <label for="Password">Password</label>
  <input type="Password" id="Password" name="Password" required>
  </div>


  <div class="input-group">
    <label for="Phone">Phone</label>
    <input type="Phone" id="Phone" name="Phone" required>
    </div>
    <button type="submit" class="login-btn">Sign Up</button>

    <p class="signup-text"> have an account? <a href="/AI%20Coach%20Vision/player/action/login.php"> Log In</a></p>

  </div>
 </form>
</div>
 </body>
  </html>
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #ffff;
  }
  
  .login-container {
    width: 400px;
    background:none;
    margin-top: 3px;
    margin-bottom: 30px;
    border:none;
    box-shadow: none;
    text-align: center; 
    position: relative; 
    text-align: center; 
  }
  
  .logo {
    width: 430px;
    height: auto;
    margin: 0 auto -106px -44px;
    position: relative;
    z-index: 1;
  }
  
  h2 {
    color: #005f73;
    margin-bottom: 20px;
    font-size: 16px;
  }
  
  .input-group {
    padding: 3px;
    text-align: left;
    margin-bottom: 15px;
    border-radius: 5px; 
  }
  
  .input-group label {
    display: block;
    font-size: 13px;
    margin-bottom: 2px;
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
    font-size: 14px;
    text-align: center;
    position: relative;
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
