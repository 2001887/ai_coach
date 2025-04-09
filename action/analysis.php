<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Player Analysis</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
  
  $serveSpeed = $_GET['serve_speed'] ?? 'N/A';
  $shotSpeed = $_GET['shot_speed'] ?? 'N/A';
  $playerLevelBall = $_GET['player_level_ball'] ?? 'N/A';

  $bodyAngles = $_GET['body_angles'] ?? 'N/A';
  $bodyBalance = $_GET['body_balance'] ?? 'N/A';
  $movementPattern = $_GET['movement_pattern'] ?? 'N/A';
  $playerLevelBody = $_GET['player_level_body'] ?? 'N/A';

  $challenge = $_GET['challenge'] ?? 'N/A';
  $recommendBall = $_GET['recommend_ball'] ?? 'N/A';
  $recommendBody = $_GET['recommend_body'] ?? 'N/A';

  $videoPath = $_GET['video'] ?? 'default-video.mp4';
  $playerName = $_GET['player_name'] ?? 'Player Name';
  $date = date('Y-m-d');
?>
  
  <header>
    <div class="main-header">
      <div class="left-section">
        <span >Mariam</span>
        <span id="date"></span>
      </div>
      <div class="right-section">
        <a href="#">HISTORY</a>
        <a href="#">HOME</a>
      </div>
    </div>
  </header>

  <!-- Video Section -->
  <div class="section" style="margin-top: 80px;">
    <div class="video-box">
      <video controls width="400" height="250">
        <source src="your-video.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

  <!-- Ball State -->
  <div class="section card">
    <h4>Ball State</h4>
    <div class="circle-container">
      <div class="circle" id="serveSpeed">Serve Speed</div>
      <div class="circle" id="shotSpeed">Shot Speed</div>
      <div class="circle" id="ballLevel">Player Level</div>
    </div>
  </div>

  <!-- Body Position -->
  <div class="section card">
    <h4>Body Position</h4>
    <div class="circle-container">
      <div class="circle" id="bodyAngles">Body Angles</div>
      <div class="circle" id="bodyBalance">Body Balance</div>
      <div class="circle" id="movementPattern">Movement Pattern</div>
      <div class="circle" id="bodyLevel">Player Level</div>
    </div>
  </div>

  <!-- Recommendation -->
  <div class="section card">
    <h4>Recommendation</h4>
    <div class="circle-container">
      <div class="circle" id="challenges">Challenges</div>
      <div class="circle" id="ballTips">Ball State</div>
      <div class="circle" id="bodyTips">Body Position</div>
    </div>
  </div>

  <!-- Buttons -->
  <div class="buttons">
  <button onclick="fakeAI()"> Turn on temporary intelligence </button>
    <button>Download Report</button>
    <button> New Analysis</button>
  </div>
  <script>
    document.getElementById("date").textContent = new Date().toLocaleDateString();

    function fakeAI() {
      document.getElementById("serveSpeed").textContent = "130 km/h";
      document.getElementById("shotSpeed").textContent = "110 km/h";
      document.getElementById("ballLevel").textContent = "70%";

      document.getElementById("bodyAngles").textContent = " 90°";
      document.getElementById("bodyBalance").textContent = "very good";
      document.getElementById("movementPattern").textContent = "good";
      document.getElementById("bodyLevel").textContent = "90%";

      document.getElementById("challenges").textContent = "Balance: 1-leg x3";
document.getElementById("ballTips").textContent = "Hit center of racket";
document.getElementById("bodyTips").textContent = "Keep feet and shoulders stable";


    }
  </script>

 
</body>
</html>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
  }
  
  /* Header */
  .main-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background-color: #025e6a;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    font-size: 14px;
    border-bottom: 1px solid #ddd;
  }
  
  .left-section span {
    margin-right: 15px;
  }
  
  .right-section a {
    margin-left: -5px;
    margin-right: 40px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 3px;
  }
  
  .right-section a:hover{
    color: #729aa2;
  }
  
  .section {
    text-align: center;
    margin: 40px auto;
    width: 90%;
    max-width: 900px;
  }
  
  .video-box {
    border: 1px solid #ccc;
    border-radius: 15px;
    padding: 20px;
    border: 2px solid #8ec3cf;
  }
  
  h4 {
    margin-bottom: 20px;
    font-size: 10px;
    color: #005f73;
  }
  
  /* Card-style sections */
  .card {
    background-color: #ffff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(137, 132, 132, 0.05);
    border: 2px solid #8ec3cf;
  }
  
  .circle-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 20px;
  }
  
  .circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #8ec3cf;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 14px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    border: 2px solid #8eb8c0;
  }
  
  .circle:hover {
    transform: scale(1.05);
  }
  
  /* Buttons */
  .buttons {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 40px 0;
  }
  
  button {
    padding: 10px 20px;
    border: 2px solid #8ec3cf;
    background-color: transparent;
    color: #005f73;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
  }
  
  button:hover {
    background-color: #005f73;
    color: white;
    transform: scale(1.05);
  }



