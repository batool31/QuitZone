<?php
session_start();
include 'data.Base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal_text = $_POST['goal_text'];
    $user_id = $_SESSION['user_id'] ;

    $stmt = $conn->prepare("INSERT INTO goals (user_id, goal_text) VALUES (?, ?)");
    
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("is", $user_id, $goal_text);
    $stmt->execute();

    header("Location: goals.php");
}
?>
