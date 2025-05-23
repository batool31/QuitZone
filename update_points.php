<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (!isset($_POST['points']) || !is_numeric($_POST['points'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid points']);
    exit;
}

require 'data.Base.php';

$userId = $_SESSION['user_id'];
$newPoints = intval($_POST['points']);

$stmt = $conn->prepare("UPDATE users SET points = ? WHERE id = ?");
$stmt->bind_param("ii", $newPoints, $userId);
$stmt->execute();

if ($stmt->affected_rows >= 0) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update points']);
}
?>
