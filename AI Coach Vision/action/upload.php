<?php
$targetDir = "uploads/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true); 
}

if (isset($_FILES["video"])) {
    $ext = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
    $videoName = "video_" . time() . "." . $ext;
    $targetFile = $targetDir . basename($videoName);

    if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
        echo "تم رفع الفيديو: " . $videoName;
    } else {
        echo "فشل رفع الفيديو.";
    }
} else {
    echo "لم يتم استقبال أي فيديو.";
}
?>
