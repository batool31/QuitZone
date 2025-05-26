<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require 'data.Base.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, title, description, type, duration FROM challenges WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$challenges = [];

while ($row = $result->fetch_assoc()) {
    $challenges[] = $row;
}

echo json_encode(['success' => true, 'challenges' => $challenges]);
?>
