<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../styles/register.css">
<title>register</title>

<body>
  <div class="login-container">
    <img src="..\images\logo-removebg-preview.png" alt="AI COACH logo" class="logo">
    <h2>Create New Account</h2>
    <form action="../action/register.php" method="POST">

      <div class="input-group">
        <label for="Email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="input-group">
        <label for="Username">Username</label>
        <input type="Username" id="Username" name="name" required>
      </div>


      <div class="input-group">
        <label for="Password">Password</label>
        <input type="Password" id="Password" name="password" required>
      </div>


      <div class="input-group">
        <label for="Phone">Phone</label>
        <input type="Phone" id="Phone" name="phoneNumber" required>
      </div>
      <button type="submit" class="login-btn">Sign Up</button>

      <p class="signup-text"> have an account? <a href="..\pages\login.php"> Log In</a></p>

  </div>
  </form>
  </div>
</body>

</html>