<?php
include 'data.Base.php';  // تأكد ان هذا الملف يحتوي على اتصال قاعدة البيانات $conn

$sql = "SELECT u.username, l.login_time, l.success 
        FROM login_history l
        JOIN users u ON l.user_id = u.id
        ORDER BY l.login_time DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching login history: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login History</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      background-color: #f7f7f7;
    }

    h2 {
      color:#263238;
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color:#eb7e74;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .status-success {
      color: green;
      font-weight: bold;
    }

    .status-fail {
      color: red;
      font-weight: bold;
    }

    .back-button {
      display: block;
      width: 250px;
      margin: 30px auto 0;
      text-align: center;
      background-color:rgb(43, 41, 71);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .back-button:hover {
      background-color:#eb7e74;
    }
  </style>
</head>
<body>

  <h2>🔐 Login History</h2>

  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['login_time']) ?></td>
          <td class="<?= $row['success'] ? 'status-success' : 'status-fail' ?>">
            <?= $row['success'] ? '✔️ Successful' : '❌ Failed' ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <a href="admin_dashboard.php" class="back-button">← Back to Dashboard</a>

</body>
</html>
