<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload vedio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="logo">AI Coach</div>
        <nav class="navigation">
            <a href="#">HOM</a>
            <a href="#">LOG OUT</a>
        </nav>
    </header>
    <section class="main">
        <div>
            <h2></h2>
        </div>
    </section>
    <main class="main-content">
        <div class="icon-container">
            <div class="icon">
                <a href="camera.php" target="_blank" style="text-decoration: none; color: inherit;">
                    <img src="camera-icon.png" alt="Camera" style="cursor: pointer;">
                    <p>Camera</p>
                </a>
            </div>            
            <br>
            <br>
            <br>
            <div class="icon">
                <label for="uploadInput">
                    <img src="upload-icon.png" alt="Upload" style="cursor: pointer;">
                    <p>Upload</p>
                </label>
                <form action="upload.php" method="POST" enctype="multipart/form-data" style="display: none;">
                    <input type="file" name="video" accept="video/*" id="uploadInput" onchange="this.form.submit()">
                </form>
            </div>            
        </div>
    </main>
</body>
</html>
<style>
 body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color:#fff;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #005f73;
    color:#ffff;
    position: fixed;
    width: 100%; 
    z-index: 1000; 
}

.logo {
    font-size: 1.5em;
    font-weight: bold;
}

.navigation a {
    text-decoration: none;
    color: #fff;
    margin-left:3px;
    margin-right: 40px;
    font-size: 1em;
    white-space: nowrap;
}
.navigation a:hover{
    color: #729aa2;
}
.main{
    width: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: url(ooi.png) no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    border: #b4afaf;
}

.main-content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 50px);
}

.icon-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: center;
}

.icon {
    text-align: center;
    background-color: #fff;
    width: 21.25em;
    box-shadow: none;
    padding: 25px;
    margin: 15px;
    transition: 0.7s ease;
}
.icon:hover{
    transform: scale(1.1);
}
.icon img {
    width: 80px;
    height: 80px;
}

.icon p {
    font-size: 1.2em;
    margin-top: 10px;
    color: #005f73;
}
</style>
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
