<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera</title>
    <link rel="stylesheet" href="camera.css">
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
<style>
body {
    font-family: 'Cairo', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    text-align: center;
}

.header {
    background-color: #4a90e2;
    color: white;
    padding: 15px 0;
    font-size: 24px;
    font-weight: bold;
}

.logo {
    font-size: 28px;
}

.camera-container {
    margin-top: 40px;
}

h2 {
    margin-bottom: 20px;
    color: #005f73;
}

.video-frame {
    display: inline-block;
    border: 4px solid #005f73;
    border-radius: 20px;
    overflow: hidden;
    width: 80%;
    max-width: 640px;
    height: auto;
    background-color: #000;
}

video {
    width: 100%;
    height: auto;
}

.buttons {
    margin-top: 20px;
}

button {
    background-color: #005f73;
    color: white;
    border: none;
    padding: 12px 24px;
    margin: 10px;
    font-size: 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #729aa2;
}

