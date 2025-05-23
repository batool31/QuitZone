<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require 'data.Base.php';

$data = json_decode(file_get_contents('php://input'), true);

$title = trim($data['title']);
$description = trim($data['description']);
$type = $data['type'];
$duration = intval($data['duration']);
$user_id = $_SESSION['user_id'];

if (empty($title) || empty($description) || $duration < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO challenges (user_id, title, description, type, duration) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $user_id, $title, $description, $type, $duration);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
