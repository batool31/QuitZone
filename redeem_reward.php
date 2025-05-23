<?php
// تفعيل رسائل الخطأ أثناء التطوير
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// حفظ البيانات القادمة لتصحيح الأخطاء
file_put_contents("log_check.txt", json_encode($_POST) . "\n", FILE_APPEND);
file_put_contents("session_debug.txt", json_encode($_SESSION) . "\n", FILE_APPEND);

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// تحقق من بيانات POST
if (!isset($_POST['reward_id']) || !is_numeric($_POST['reward_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid reward ID']);
    exit;
}

// الاتصال بقاعدة البيانات
if (!file_exists('data.Base.php')) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database config file not found']);
    exit;
}

require 'data.Base.php';

if (!isset($conn) || !$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$userId = intval($_SESSION['user_id']);
$rewardId = intval($_POST['reward_id']);

// بدء المعاملة
$conn->begin_transaction();

try {
    // استعلام نقاط المستخدم
    $stmt = $conn->prepare("SELECT points FROM users WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed (users): " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("User not found");
    }

    $user = $result->fetch_assoc();
    $currentPoints = intval($user['points']);
    $stmt->close();

    // استعلام تكلفة المكافأة
    $stmt = $conn->prepare("SELECT points_cost FROM rewards WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed (rewards): " . $conn->error);
    }

    $stmt->bind_param("i", $rewardId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Reward not found");
    }

    $reward = $result->fetch_assoc();
    $cost = intval($reward['points_cost']);
    $stmt->close();

    if ($currentPoints < $cost) {
        throw new Exception("Not enough points");
    }

    // خصم النقاط
    $newPoints = $currentPoints - $cost;
    $stmt = $conn->prepare("UPDATE users SET points = ? WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed (update users): " . $conn->error);
    }

    $stmt->bind_param("ii", $newPoints, $userId);
    $stmt->execute();
    $stmt->close();

    // تسجيل المكافأة
    $stmt = $conn->prepare("INSERT INTO user_rewards (user_id, reward_id, redeemed_at) VALUES (?, ?, NOW())");
    if (!$stmt) {
        throw new Exception("Prepare failed (insert reward): " . $conn->error);
    }

    $stmt->bind_param("ii", $userId, $rewardId);
    $stmt->execute();
    $stmt->close();

    // حفظ التغييرات
    $conn->commit();

    echo json_encode(['success' => true, 'new_points' => $newPoints]);

} catch (Exception $e) {
    $conn->rollback();

    // تسجيل الخطأ
    file_put_contents("debug_log.txt", "Redemption error: " . $e->getMessage() . "\n", FILE_APPEND);

    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
