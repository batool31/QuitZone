<?php
session_start();
include 'data.Base.php';

header('Content-Type: application/json');

// تحقق من تسجيل دخول المستخدم
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// تحقق من البيانات القادمة من POST
if (isset($_POST['goal_id'], $_POST['is_completed'])) {
    $goal_id = intval($_POST['goal_id']);
    $completed = intval($_POST['is_completed']);
    $user_id = $_SESSION['user_id'];

    try {
        // تحديث حالة الهدف في قاعدة البيانات
        $stmt = $conn->prepare("UPDATE user_goals SET is_completed = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$completed, $goal_id, $user_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Goal updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No goal updated']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
