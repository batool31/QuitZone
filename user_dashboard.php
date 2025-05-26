<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard - QuitZone</title>
  <link rel="stylesheet" href="grad.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <header class="navbar">
    <div class="container">
      <a href="home.php" class="logo">
        <span>QuitZone</span>
        <span class="emoji">🚭</span>
      </a>
      <nav class="nav-desktop">
        <ul>
          <li><a href="user_dashboard.php" class="nav-link active">Dashboard</a></li>
          <li><a href="progress.php" class="nav-link">Progress</a></li>
          <li><a href="challenges.php" class="nav-link">Challenges</a></li>
          <li><a href="logout.php" class="login-btn">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <h2>Welcome Back, <?= htmlspecialchars($_SESSION['user_name']); ?> 🌱</h2>
    <p>Your smoke-free journey continues! Explore your progress and take on new challenges.</p>
    <div class="btn-group">

</body>
</html>
