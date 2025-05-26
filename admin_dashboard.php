<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - QuitZone</title>
  <link rel="stylesheet" href="grad.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
   
    
    #addStoryForm {
      max-width: 600px;
      margin: 30px auto 40px auto;
      padding: 25px 30px;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    #addStoryForm h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
      font-size: 28px;
    }
    #addStoryForm input[type="text"],
    #addStoryForm input[type="number"],
    #addStoryForm input[type="file"],
    #addStoryForm textarea {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
      font-family: inherit;
    }
    #addStoryForm input[type="text"]:focus,
    #addStoryForm input[type="number"]:focus,
    #addStoryForm textarea:focus {
      border-color: #4CAF50;
      outline: none;
    }
    #addStoryForm textarea {
      resize: vertical;
      min-height: 120px;
    }
    #addStoryForm button {
      width: 100%;
      padding: 14px;
      background-color: #4CAF50;
      border: none;
      border-radius: 6px;
      color: white;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    #addStoryForm button:hover {
      background-color: #45a049;
    }
    .main-content {
      max-width: 1100px;
      margin: 0 auto 40px auto;
      padding: 0 15px;
      color: #444;
      font-size: 18px;
    }
    .main-content h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
  </style>
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
          <li><a href="admin_dashboard.php" class="nav-link active">Dashboard</a></li>
          <li><a href="manage_users.php" class="nav-link">Manage Users</a></li>
          <li><a href="logout.php" class="login-btn">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <form id="addStoryForm" method="POST" action="add_story.php" enctype="multipart/form-data">
    <h2>Add Success Story</h2>
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="number" name="smoker_years" placeholder="Years as smoker" required>
    <input type="text" name="smoke_free_duration" placeholder="Smoke Free Duration" required>
    <textarea name="story" placeholder="Story" required></textarea>
    <input type="text" name="achievements" placeholder="Achievements (comma separated)" required>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Add Story</button>
  </form>

  <section class="main-content">
    <div class="container">
      <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['user_name']); ?> 👨‍💼</h2>
      <p>Here you can manage users, view statistics, and control QuitZone content.</p>
    </div>
  </section>

</body>
</html>
