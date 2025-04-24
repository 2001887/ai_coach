<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link rel="stylesheet" href="../styles/upload.css">
</head>
<body>
    <header class="header">
        <div class="logo">AI Coach</div>
        <nav class="navigation">
            <a href="../pages/history.php">History</a>
            <a href="../pages/login.php">Logout</a>
        </nav>
    </header>
    
    <main class="main-content">
        <div class="icon-container">
            <div class="icon">
                <a href="../pages/camera.php" target="_blank" style="text-decoration: none; color: inherit;">
                    <img src="../images/camera-icon.png" alt="Camera" style="cursor: pointer;">
                    <p>Camera</p>
                </a>
            </div>            
            <br>
            <br>
            <br>
            <div class="icon">
                <label for="uploadInput">
                    <img src="../images/upload-icon.png" alt="Upload" style="cursor: pointer;">
                    <p>Upload</p>
                </label>
                <form action="../action/upload.php" method="POST" enctype="multipart/form-data" style="display: none;">
                    <input type="file" name="video" accept="video/*" id="uploadInput" onchange="this.form.submit()">
                </form>
            </div>            
        </div>
    </main>
</body>
</html>