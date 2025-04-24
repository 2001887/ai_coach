from flask import Flask, request, send_file, jsonify
import cv2
import mediapipe as mp
import torch
import numpy as np
import json
import math
from collections import deque
import os

app = Flask(__name__)

# Initialize MediaPipe Pose
mp_pose = mp.solutions.pose
pose = mp_pose.Pose(
    static_image_mode=False,
    model_complexity=1,
    min_detection_confidence=0.5,
    min_tracking_confidence=0.5
)

# Initialize YOLOv5 for ball detection
model = torch.hub.load('ultralytics/yolov5', 'yolov5s', pretrained=True)
model.eval()
model.conf = 0.1  # Lower confidence threshold for better ball detection

# Directory to store uploaded videos and metrics
UPLOAD_FOLDER = 'uploads'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

def calculate_angle(a, b, c):
    """Calculate angle between three points (degrees)."""
    ab = math.sqrt((a.x - b.x)**2 + (a.y - b.y)**2)
    bc = math.sqrt((b.x - c.x)**2 + (b.y - c.y)**2)
    ac = math.sqrt((a.x - c.x)**2 + (a.y - c.y)**2)
    angle = math.degrees(math.acos((ab**2 + bc**2 - ac**2) / (2 * ab * bc)))
    return angle

def get_body_metrics(landmarks):
    """Extract body angles, balance, and position."""
    body_angles = {}
    right_shoulder = landmarks[mp_pose.PoseLandmark.RIGHT_SHOULDER]
    right_elbow = landmarks[mp_pose.PoseLandmark.RIGHT_ELBOW]
    right_wrist = landmarks[mp_pose.PoseLandmark.RIGHT_WRIST]
    body_angles["right_elbow"] = calculate_angle(right_shoulder, right_elbow, right_wrist)

    left_hip = landmarks[mp_pose.PoseLandmark.LEFT_HIP]
    right_hip = landmarks[mp_pose.PoseLandmark.RIGHT_HIP]
    com_x = (left_hip.x + right_hip.x) / 2
    com_y = (left_hip.y + right_hip.y) / 2
    body_balance = {"center_of_mass": (com_x, com_y)}

    body_position = {"torso_x": (left_hip.x + right_hip.x) / 2}

    return body_angles, body_balance, body_position

def detect_ball(frame):
    """Detect ball using YOLOv5."""
    results = model(frame)
    detections = results.xyxy[0].cpu().numpy()
    for det in detections:
        if det[5] == 32:
            confidence = det[4]
            print(f"Ball detected with confidence: {confidence}")
            x1, y1, x2, y2 = map(int, det[:4])
            return (x1 + x2) / 2, (y1 + y2) / 2
    return None

def calculate_speed(positions, fps, scale_factor=1.0):
    """Calculate speed from positions (pixels/sec to m/s)."""
    if len(positions) < 2:
        return 0
    dist = math.sqrt((positions[-1][0] - positions[-2][0])**2 + (positions[-1][1] - positions[-2][1])**2)
    speed = dist * fps * scale_factor
    return speed

def process_video(video_path):
    """Process the video and generate metrics."""
    cap = cv2.VideoCapture(video_path)
    if not cap.isOpened():
        raise FileNotFoundError("Video file not found or cannot be opened.")

    fps = cap.get(cv2.CAP_PROP_FPS)
    total_frames = int(cap.get(cv2.CAP_PROP_FRAME_COUNT))
    print(f"Video opened successfully. FPS: {fps}, Total frames: {total_frames}")

    metrics_history = []
    ball_positions = deque(maxlen=10)
    prev_landmarks = None
    frame_count = 0

    while cap.isOpened():
        ret, frame = cap.read()
        if not ret:
            print(f"Finished processing {frame_count} frames.")
            break

        frame_count += 1
        if frame_count % 100 == 0:
            print(f"Processing frame {frame_count}/{total_frames}")

        frame_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        metrics = {"frame": frame_count}

        # Pose estimation
        pose_results = pose.process(frame_rgb)
        if pose_results.pose_landmarks:
            print(f"Frame {frame_count}: Pose detected.")
            landmarks = pose_results.pose_landmarks.landmark
            body_angles, body_balance, body_position = get_body_metrics(landmarks)
            metrics["body_angles"] = body_angles
            metrics["body_balance"] = body_balance
            metrics["body_position"] = body_position

            if prev_landmarks:
                torso_delta = abs(landmarks[mp_pose.PoseLandmark.LEFT_HIP].x - prev_landmarks[mp_pose.PoseLandmark.LEFT_HIP].x)
                metrics["movement_pattern"] = "sprint" if torso_delta > 0.05 else "stationary"
            prev_landmarks = landmarks

            right_wrist = landmarks[mp_pose.PoseLandmark.RIGHT_WRIST]
            right_shoulder = landmarks[mp_pose.PoseLandmark.RIGHT_SHOULDER]
            metrics["challenges"] = right_wrist.y < right_shoulder.y
        else:
            print(f"Frame {frame_count}: No pose detected.")

        # Ball detection and speed
        ball_pos = detect_ball(frame_rgb)
        if ball_pos:
            print(f"Frame {frame_count}: Ball detected at position {ball_pos}.")
            ball_positions.append(ball_pos)
            metrics["ball_state"] = {"position": list(ball_pos)}
            speed = calculate_speed(ball_positions, fps, scale_factor=0.01)
            metrics["serve_speed" if frame_count < 100 else "shot_speed"] = speed
        else:
            print(f"Frame {frame_count}: No ball detected.")
            metrics["ball_state"] = {"position": [0, 0]}
            metrics["serve_speed" if frame_count < 100 else "shot_speed"] = 0

        if "shot_speed" in metrics and "movement_pattern" in metrics:
            metrics["player_level"] = "advanced" if metrics["shot_speed"] > 20 and metrics["movement_pattern"] == "sprint" else "beginner"

        metrics_history.append(metrics)

    cap.release()
    pose.close()

    # Save metrics to JSON
    metrics_path = os.path.join(app.config['UPLOAD_FOLDER'], "tennis_metrics.json")
    print(f"Saving {len(metrics_history)} frames of metrics to {metrics_path}")
    with open(metrics_path, "w") as f:
        json.dump(metrics_history, f, indent=4)

    return metrics_path

@app.route('/upload', methods=['POST'])
def upload_video():
    try:
        # Check if a file is part of the request
        if 'video' not in request.files:
            return jsonify({"error": "No video file provided"}), 400

        video_file = request.files['video']
        if video_file.filename == '':
            return jsonify({"error": "No selected file"}), 400

        # Save the uploaded video
        video_path = os.path.join(app.config['UPLOAD_FOLDER'], video_file.filename)
        video_file.save(video_path)
        print(f"Video saved to {video_path}")

        # Process the video and generate metrics
        metrics_path = process_video(video_path)

        # Return the metrics file
        return send_file(metrics_path, as_attachment=True, download_name="tennis_metrics.json")

    except Exception as e:
        print(f"Error: {str(e)}")
        return jsonify({"error": str(e)}), 500

    finally:
        # Clean up: Remove the uploaded video and metrics file
        if os.path.exists(video_path):
            os.remove(video_path)
        if os.path.exists(metrics_path):
            os.remove(metrics_path)

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)