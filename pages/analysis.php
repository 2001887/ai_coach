<?php
$metrics_folder = isset($_GET['metrics_folder']) ? $_GET['metrics_folder'] : '';
$video_filename = isset($_GET['video']) ? $_GET['video'] : 'video_1744141906.mp4';
// $metrics_file = $metrics_folder ? "../metrics/{$metrics_folder}/tennis_metrics.json" : '../metrics/tennis_metrics.json';
$metrics_file =  '../metrics/tennis_metrics.json';
$video_file = "../videos/{$video_filename}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Player Analysis</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }

    header {
      background: linear-gradient(90deg, #1b3b6a, #2a4b8a);
      color: white;
      padding: 15px 30px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .left-section, .right-section {
      display: flex;
      gap: 20px;
    }

    .right-section a {
      color: #d09915;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    .right-section a:hover {
      color: #f0b428;
    }

    .section {
      margin: 20px;
      padding: 20px;
    }

    .video-box {
      display: flex;
      justify-content: center;
    }

    video {
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card h4 {
      margin: 0 0 15px 0;
      color: #1b3b6a;
      font-size: 1.2em;
    }

    .circle-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }

    .circle {
      background-color: #e8ecef;
      border-radius: 50%;
      width: 120px;
      height: 120px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 10px;
      font-size: 0.9em;
      color: #333;
      transition: transform 0.3s, background-color 0.3s;
    }

    .circle:hover {
      transform: scale(1.05);
      background-color: #d09915;
      color: white;
    }

    .circle span {
      display: block;
      margin-top: 5px;
      font-weight: bold;
    }

    .buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin: 20px;
    }

    button {
      background-color: #1b3b6a;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #2a4b8a;
    }

    @media (max-width: 768px) {
      .main-header {
        flex-direction: column;
        gap: 10px;
      }

      .circle {
        width: 100px;
        height: 100px;
        font-size: 0.8em;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="main-header">
      <div class="left-section">
        <span>Player Name</span>
        <span>Date</span>
      </div>
      <div class="right-section">
        <a href="./history.php">HISTORY</a>
        <a href="../pages/upload.php">HOME</a>
      </div>
    </div>
  </header>

  <div class="section">
    <div class="video-box">
      <video id="playerVideo" controls width="400" height="250">
        <source src="<?php echo $video_file; ?>" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

  <div class="section card">
    <h4>Ball State</h4>
    <div class="circle-container">
      <div class="circle" id="serve-speed">Serve Speed<span>-</span></div>
      <div class="circle" id="shot-speed">Shot Speed<span>-</span></div>
      <div class="circle" id="player-level-ball">Player Level<span>-</span></div>
    </div>
  </div>

  <div class="section card">
    <h4>Body Position</h4>
    <div class="circle-container">
      <div class="circle" id="body-angles">Body Angles<span>-</span></div>
      <div class="circle" id="body-balance">Body Balance<span>-</span></div>
      <div class="circle" id="movement-pattern">Movement Pattern<span>-</span></div>
      <div class="circle" id="player-level-body">Player Level<span>-</span></div>
    </div>
  </div>

  <div class="section card">
    <h4>Recommendation</h4>
    <div class="circle-container">
      <div class="circle" id="challenges">Challenges<span>-</span></div>
      <div class="circle" id="ball-state">Ball State<span>-</span></div>
      <div class="circle" id="body-position">Body Position<span>-</span></div>
    </div>
  </div>

  <div class="buttons">
    <button > <a style="color: white; text-decoration: none" href="./upload.php">New Analysis</a></button>
  </div>

  <script>
    let metricsData = [];
    let fps = 30;

    fetch('<?php echo $metrics_file; ?>')
      .then(response => response.json())
      .then(data => {
        metricsData = data;
        console.log('Metrics loaded:', metricsData);
      })
      .catch(error => console.error('Error loading metrics:', error));

    const video = document.getElementById('playerVideo');

    video.addEventListener('timeupdate', () => {
      const currentTime = video.currentTime;
      const currentFrame = Math.floor(currentTime * fps) + 1;

      const frameMetrics = metricsData.find(metric => metric.frame === currentFrame) || {};

      console.log('Frame Metrics:', frameMetrics);
      document.querySelector('#serve-speed span').textContent = frameMetrics.serve_speed ? `${frameMetrics.serve_speed.toFixed(2)} m/s` : '-';
      document.querySelector('#shot-speed span').textContent = frameMetrics.shot_speed ? `${frameMetrics.shot_speed.toFixed(2)} m/s` : '-';
      document.querySelector('#player-level-ball span').textContent = frameMetrics.player_level || '-';

      document.querySelector('#body-angles span').textContent = frameMetrics.body_angles ? `${frameMetrics.body_angles.right_elbow.toFixed(1)}°` : '-';
      document.querySelector('#body-balance span').textContent = frameMetrics.body_balance ? `(${frameMetrics.body_balance.center_of_mass[0].toFixed(2)}, ${frameMetrics.body_balance.center_of_mass[1].toFixed(2)})` : '-';
      document.querySelector('#movement-pattern span').textContent = frameMetrics.movement_pattern || '-';
      document.querySelector('#player-level-body span').textContent = frameMetrics.player_level || '-';

      document.querySelector('#challenges span').textContent = frameMetrics.challenges !== undefined ? (frameMetrics.challenges ? 'Yes' : 'No') : '-';
      document.querySelector('#ball-state span').textContent = frameMetrics.ball_state ? `(${frameMetrics.ball_state.position[0].toFixed(0)}, ${frameMetrics.ball_state.position[1].toFixed(0)})` : '-';
      document.querySelector('#body-position span').textContent = frameMetrics.body_position ? `${frameMetrics.body_position.torso_x.toFixed(2)}` : '-';
    });

    video.addEventListener('ended', resetMetrics);
    video.addEventListener('pause', resetMetrics);

    function resetMetrics() {
      document.querySelectorAll('.circle span').forEach(span => span.textContent = '-');
    }
  </script>
</body>
</html>