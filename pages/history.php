<?php
include('../db.php');
session_start();

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch videos for the logged-in customer
$stmt = $conn->prepare("SELECT video_path, metrics_path, created_at FROM videos WHERE customer_id = ? ORDER BY created_at DESC");
$stmt->execute([$customer_id]);
$videos = [];
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $videos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل الفيديوهات</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(90deg, #1b3b6a, #2a4b8a);
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5em;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navigation {
            display: flex;
            gap: 20px;
        }

        .navigation a {
            color: #d09915;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navigation a:hover {
            color: #f0b428;
            transform: scale(1.05);
        }

        .main-content {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .video-list {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s ease;
        }

        .video-list:hover {
            transform: translateY(-5px);
        }

        .video-list h2 {
            color: #1b3b6a;
            font-size: 1.8em;
            margin-bottom: 20px;
            border-bottom: 2px solid #d09915;
            padding-bottom: 10px;
        }

        .video-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid #e8ecef;
            transition: background 0.3s ease;
        }

        .video-item:last-child {
            border-bottom: none;
        }

        .video-item:hover {
            background: #f9f9f9;
            border-radius: 8px;
        }

        .video-item a {
            text-decoration: none;
            color: #1b3b6a;
            font-weight: 600;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        .video-item a:hover {
            color: #d09915;
        }

        .video-date {
            color: #666;
            font-size: 0.9em;
            font-weight: 400;
        }

        .no-videos {
            text-align: center;
            color: #666;
            font-size: 1.2em;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .header {
                padding: 10px 15px;
            }

            .logo {
                font-size: 1.2em;
            }

            .navigation a {
                font-size: 0.9em;
            }

            .main-content {
                margin: 15px auto;
                padding: 0 10px;
            }

            .video-list {
                padding: 15px;
            }

            .video-list h2 {
                font-size: 1.5em;
            }

            .video-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .video-item a {
                font-size: 1em;
            }

            .video-date {
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">AI Coach</div>
        <nav class="navigation">
            <a href="../pages/upload.php">رفع فيديو</a>
            <a href="../pages/login.php">تسجيل الخروج</a>
        </nav>
    </header>
    
    <main class="main-content">
        <div class="video-list">
            <h2>سجل الفيديوهات</h2>
            <?php if (empty($videos)): ?>
                <p class="no-videos">لا توجد فيديوهات بعد.</p>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <?php
                    $video_name = basename($video['video_path']);
                    $metrics_folder = basename(dirname($video['metrics_path']));
                    $created_at = date('Y-m-d H:i', strtotime($video['created_at']));
                    ?>
                    <div class="video-item">
                        <a href="../pages/analysis.php?metrics_folder=<?php echo $metrics_folder; ?>&video=<?php echo $video_name; ?>">
                            <?php echo htmlspecialchars($video_name); ?>
                        </a>
                        <span class="video-date"><?php echo $created_at; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>