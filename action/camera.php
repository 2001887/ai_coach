<?php
include('../db.php');
session_start();

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'error' => 'غير مسجل الدخول']);
    exit();
}

$customer_id = $_SESSION['customer_id'];

$targetDirVideos = "../videos/";
$targetDirMetrics = "../metrics/";

if (!is_dir($targetDirVideos)) {
    mkdir($targetDirVideos, 0777, true);
}
if (!is_dir($targetDirMetrics)) {
    mkdir($targetDirMetrics, 0777, true);
}

if (isset($_FILES["video"])) {
    $videoName = $_FILES["video"]["name"];
    $targetVideoFile = $targetDirVideos . basename($videoName);

    // Save video locally
    if (!move_uploaded_file($_FILES["video"]["tmp_name"], $targetVideoFile)) {
        echo json_encode(['success' => false, 'error' => 'فشل رفع الفيديو']);
        exit();
    }

    // // Prepare to send video to Flask app
    // $url = "https://aitennis11.pythonanywhere.com/upload";
    // $ch = curl_init($url);

    // $postFields = [
    //     'video' => new CURLFile($targetVideoFile, mime_content_type($targetVideoFile), $videoName)
    // ];

    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // // Execute the request and get the metrics file
    // $response = curl_exec($ch);
    // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close($ch);

    // if ($httpCode != 200) {
    //     echo json_encode(['success' => false, 'error' => 'فشل في معالجة الفيديو: ' . $response]);
    //     exit();
    // }

    $response = "{}";

    // Generate random folder for metrics
    $randomFolder = uniqid();
    $metricsFolder = $targetDirMetrics . $randomFolder;
    mkdir($metricsFolder, 0777, true);

    // Save metrics file locally
    $metricsFile = $metricsFolder . "/tennis_metrics.json";
    file_put_contents($metricsFile, $response);

    // Save paths to database
    $relativeVideoPath = "/videos/" . $videoName;
    $relativeMetricsPath = "/metrics/" . $randomFolder . "/tennis_metrics.json";
    $stmt = $conn->prepare("INSERT INTO videos (customer_id, video_path, metrics_path) VALUES (?, ?, ?)");
    $stmt->execute([$customer_id, $relativeVideoPath, $relativeMetricsPath]);

    // Return success response with video name and metrics folder
    echo json_encode([
        'success' => true,
        'video_name' => $videoName,
        'metrics_folder' => $randomFolder
    ]);
    exit();
} else {
    echo json_encode(['success' => false, 'error' => 'لم يتم استقبال أي فيديو']);
    exit();
}
?>