<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// DB connection
$pdo = new PDO("mysql:host=localhost;dbname=quitzone;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Get user count
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Get challenges data (join with username)
$stmt = $pdo->query("
    SELECT c.id, u.username, c.title, c.description, c.type, c.duration, c.created_at, c.is_default
    FROM challenges c
    LEFT JOIN users u ON c.user_id = u.id
    ORDER BY c.created_at DESC
");
$challenges = $stmt->fetchAll();

// Get user goals (join with username)
$goalStmt = $pdo->query("
    SELECT g.id, u.username, g.goal_text, g.is_completed, g.created_at
    FROM user_goals g
    LEFT JOIN users u ON g.user_id = u.id
    ORDER BY g.created_at DESC
");
$user_goals = $goalStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - QuitZone</title>
  <link rel="stylesheet" href="grad.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #eb7e74;
      --primary-light: #ffedea;
      --primary-dark: #d46b60;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: var(--primary-light);
    }
    .dashboard-header {
      background-color: var(--primary);
      color: white;
      padding: 25px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .dashboard-header h1 {
      margin: 0;
      font-size: 28px;
      color:white;
    }
    .dashboard-header p {
      margin: 5px 0 0;
      font-size: 16px;
      opacity: 0.9;
    }
    .content-wrapper {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.07);
      padding: 25px 30px;
      margin-bottom: 30px;
    }
    .card h2 {
      font-size: 22px;
      margin-bottom: 20px;
      color: var(--primary);
    }
    .stats-box {
      font-size: 18px;
      color: #333;
      margin-bottom: 15px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
    }
    th, td {
      padding: 12px 16px;
      border: 1px solid #e0e0e0;
      text-align: left;
    }
    th {
      background-color: var(--primary);
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .nav-top {
      background-color: var(--primary-dark);
      padding: 15px;
      display: flex;
      justify-content: center;
      gap: 25px;
    }
    .nav-top a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }
    .nav-top a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="dashboard-header">
    <h1>Welcome Admin, <?= htmlspecialchars($_SESSION['user_name']); ?> 👨‍💼</h1>
    <p>You are viewing the QuitZone Admin Dashboard</p>
  </div>

  <div class="nav-top">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="login_history.php">Login Logs</a>
    <a href="reset_user_password.php">Reset Password</a>
    <a href="filter_users.php">User Status</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="content-wrapper">

    <div class="card">
      <h2>📊 Platform Statistics</h2>
      <div class="stats-box">Total Registered Users: <strong><?= $totalUsers ?></strong></div>
    </div>

    <div class="card">
      <h2>🏆 Challenges</h2>
      <?php if (count($challenges) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
           
            <th>Challenges</th>
            <th>Type</th>
            <th>Duration (days)</th>
            <th>Date Added</th>
            <th>Default Challenge?</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($challenges as $challenge): ?>
            <tr>
              <td><?= htmlspecialchars($challenge['id']) ?></td>
              <td><?= htmlspecialchars($challenge['username'] ?? 'N/A') ?></td>
              
              <td><?= htmlspecialchars($challenge['description']) ?></td>
              <td><?= htmlspecialchars(ucfirst($challenge['type'])) ?></td>
              <td><?= htmlspecialchars($challenge['duration']) ?></td>
              <td><?= htmlspecialchars($challenge['created_at']) ?></td>
              <td><?= $challenge['is_default'] ? '✅ Yes' : '❌ No' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p>No challenges found.</p>
      <?php endif; ?>
    </div>

    <div class="card">
      <h2>🎯 User Goals</h2>
      <?php if (count($user_goals) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Goal</th>
            <th>Status</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($user_goals as $goal): ?>
            <tr>
              <td><?= htmlspecialchars($goal['id']) ?></td>
              <td><?= htmlspecialchars($goal['username'] ?? 'N/A') ?></td>
              <td><?= htmlspecialchars($goal['goal_text']) ?></td>
              <td><?= $goal['is_completed'] ? '✅ Completed' : '❌ In Progress' ?></td>
              <td><?= htmlspecialchars($goal['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p>No user goals found.</p>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>
