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
    body {
  margin: 0;
  height: 100vh; /* ارتفاع كامل الشاشة */
  display: flex;
  justify-content: center; /* وسط أفقي */
  align-items: center;    /* وسط عمودي */
  background-color: #f7f7f7; /* لو بدك خلفية */
  font-family: 'Poppins', sans-serif;
}

.main-contentc {
  max-width: 600px; /* حجم مناسب */
  width: 90%;
  padding: 30px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
  text-align: center; /* لتوسيط النص */
  color: #444;
  font-size: 18px;
}

    .main-contentc {
  max-width: 600px; /* حجم مناسب */
  width: 90%;
  padding: 30px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
  text-align: center; /* لتوسيط النص */
  color: #444;
  font-size: 18px;
}

    .main-contentc h2 {
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
          <li><a href="login_history.php" class="nav-link">Login Logs</a></li>
          <li><a href="reset_user_password.php" class="nav-link">Reset Password</a></li>
           <li><a href="filter_users.php" class="nav-link">User Status</a></li>
          <li><a href="logout.php" class="login-btn">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  

  <section class="main-contentc">
    <div class="containerc">
      <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['user_name']); ?> 👨‍💼</h2>
      <p>Here you can manage users, view statistics, and control QuitZone content.</p>
    </div>
  </section>

</body>
</html>
