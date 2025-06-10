<?php
include 'db_connect.php'; // Include the shared connection file
require_login(); // Ensure the user is logged in

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['score']) || !isset($data['quit_date'])) {
    http_response_code(400);
    echo "Invalid data: score or quit_date missing.";
    exit();
}

$username = $_SESSION['username'];
$score = intval($data['score']);
$quit_date = ($data['quit_date'] === 'N/A' || empty($data['quit_date'])) ? NULL : $data['quit_date']; // Handle 'N/A' or empty quit_date

// Prepare and bind for secure insertion
// Using `NULL` for quit_date if not provided.
$stmt = $conn->prepare("INSERT INTO readiness_test_results (username, score, quit_date) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $username, $score, $quit_date); // 's' for string, 'i' for integer, 's' for string (date)

if ($stmt->execute()) {
    echo "Result saved successfully.";
} else {
    // Log error for debugging, don't expose DB errors to user
    error_log("Error saving readiness test result: " . $stmt->error);
    http_response_code(500); // Internal Server Error
    echo "Error saving result. Please try again.";
}

$stmt->close();
$conn->close(); // Close connection after use
?>