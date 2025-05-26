<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $conn = new mysqli("localhost", "root", "", "quitzone");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // حذف السجلات المرتبطة في user_rewards أولاً
    $conn->query("DELETE FROM user_rewards WHERE user_id = $user_id");

    // يمكنك حذف أي جداول إضافية هنا إن لزم:
    // $conn->query("DELETE FROM user_challenges WHERE user_id = $user_id");
    // $conn->query("DELETE FROM user_progress WHERE user_id = $user_id");

    // ثم حذف المستخدم نفسه
    $deleteUser = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($deleteUser) === TRUE) {
        header("Location: manage_users.php?status=deleted");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: manage_users.php");
    exit();
}
header("Location: manage_users.php?deleted=1");
exit();

?>
