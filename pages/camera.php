<?php
session_start();

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل فيديو</title>
    <link rel="stylesheet" href="../styles/camera.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .camera-container {
            margin: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .camera-container h2 {
            color: #1b3b6a;
            font-size: 1.2em;
            margin: 0 0 15px 0;
        }

        .video-frame {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        #video {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #000;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        button {
            background-color: #1b3b6a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2a4b8a;
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .camera-container {
                margin: 10px;
                padding: 15px;
            }

            .camera-container h2 {
                font-size: 1em;
            }

            #video {
                max-width: 300px;
            }

            button {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <main class="camera-container">
        <h2>تسجيل فيديو</h2>
        <div class="video-frame">
            <video id="video" autoplay playsinline muted></video>
        </div>
        <div class="buttons">
            <button id="startBtn" onclick="startRecording()">بدء التسجيل</button>
            <button id="stopBtn" onclick="stopRecording()" disabled>إيقاف التسجيل</button>
        </div>
    </main>

    <script>
        let stream;
        let mediaRecorder;
        let recordedChunks = [];
        const videoElement = document.getElementById('video');
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                videoElement.srcObject = stream;
            } catch (error) {
                alert("خطأ في الوصول إلى الكاميرا: " + error.message);
            }
        }

        function startRecording() {
            if (!stream) {
                alert("يرجى السماح بالوصول إلى الكاميرا أولاً");
                startCamera();
                return;
            }

            recordedChunks = [];
            mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/webm' });

            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = async () => {
                const blob = new Blob(recordedChunks, { type: 'video/webm' });
                const formData = new FormData();
                const videoName = `video_${Date.now()}.webm`;
                formData.append('video', blob, videoName);

                // Send the video to the backend for processing
                try {
                    const response = await fetch('../action/camera.php', {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('فشل في معالجة الفيديو');
                    }

                    const result = await response.json();
                    if (result.success) {
                        window.location.href = `../pages/analysis.php?metrics_folder=${result.metrics_folder}&video=${result.video_name}`;
                    } else {
                        alert('خطأ: ' + result.error);
                    }
                } catch (error) {
                    alert('خطأ في معالجة الفيديو: ' + error.message);
                }
            };

            mediaRecorder.start();
            startBtn.disabled = true;
            stopBtn.disabled = false;
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                videoElement.srcObject = null;
            }
            startBtn.disabled = false;
            stopBtn.disabled = true;
        }

        // Start the camera on page load
        window.onload = startCamera;
    </script>
</body>
</html>