<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera</title>
    <link rel="stylesheet" href="../styles/camera.css">
</head>
<body>
    <main class="camera-container">
        <h2> Take a Video</h2>
        <div class="video-frame">
            <video id="video" autoplay playsinline></video>
        </div>
        <div class="buttons">
            <button onclick="startCamera()">start Camera</button>
            <button onclick="stopCamera()">stop Camera</button>
        </div>
    </main>
    <script>
        let stream;

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                document.getElementById('video').srcObject = stream;
            } catch (error) {
                alert("Something went wrong" + error.message);
            }
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                document.getElementById('video').srcObject = null;
            }
        }
    </script>
</body>
</html>



