<?php
include 'data.Base.php';  // الاتصال بقاعدة البيانات

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

$sql = "SELECT * FROM success_stories ORDER BY created_at DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);

$stories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stories[] = $row;
}

header('Content-Type: application/json');
echo json_encode($stories);
?>