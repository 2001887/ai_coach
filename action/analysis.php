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



