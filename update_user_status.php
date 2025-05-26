<?php
include 'data.Base.php';
$user_id = $_POST['user_id'];
$status = $_POST['status'];
$stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $user_id);
$stmt->execute();
header("Location: manage_users.php");
?>
