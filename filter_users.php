<?php
include 'data.Base.php';

$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$query = "SELECT id, username, status FROM users";

if ($status !== 'all') {
    $query .= " WHERE status = '$status'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Status Filter</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      background-color: #f7f7f7;
    }

    form {
      margin-bottom: 25px;
      font-size: 18px;
    }

    select, button {
      padding: 8px 12px;
      font-size: 16px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      background-color:rgb(43, 41, 71);
      color: white;
      border: none;
      cursor: pointer;
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

    .status-active { color: green; font-weight: bold; }
    .status-inactive { color: orange; font-weight: bold; }
    .status-banned { color: red; font-weight: bold; }

    .back-button {
      display: block;
      width: 250px;
      margin: 30px auto 0;
      text-align: center;
      background-color:rgb(43, 41, 71);;
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
      background-color:#eb7e74
    }
  </style>
</head>
<body>

  <h2>🔍 Filter Users by Status</h2>

  <form method="GET">
    <label>Status:</label>
    <select name="status">
      <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>All</option>
      <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
      <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
      <option value="banned" <?= $status == 'banned' ? 'selected' : '' ?>>Banned</option>
    </select>
    <button type="submit">Filter</button>
  </form>

  <table>
    <tr><th>Username</th><th>Status</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['username']) ?></td>
      <td class="status-<?= $row['status'] ?>"><?= htmlspecialchars($row['status']) ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <a href="admin_dashboard.php" class="back-button">← Back to Dashboard</a>

</body>
</html>
