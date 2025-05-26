<?php
include 'data.Base.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password_raw = trim($_POST['new_password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email address.";
    } elseif (strlen($new_password_raw) < 6) {
        $message = "❌ Password must be at least 6 characters.";
    } else {
        $new_password = password_hash($new_password_raw, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if (!$stmt) {
            $message = "❌ Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $new_password, $email);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $message = "✅ Password updated successfully!";
                } else {
                    $message = "❌ Email not found or password same as before.";
                }
            } else {
                $message = "❌ Error updating password: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset User Password</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      background: #f7f7f7;
    }
    form {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h3 {
      text-align: center;
      color:#263238;
      margin-bottom: 20px;
    }
    input[type="email"],
    input[type="password"] {
      width: 90%;
      padding: 12px;
      margin: 10px 0 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }
    button,
    .back-button {
      
      display: inline-block;
      text-align: center;
      background-color:#eb7e74;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
      text-decoration: none;
      margin-top: 10px;
    }
    button:hover,
    .back-button:hover {
      background-color:#eb7e74;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <form method="POST" action="">
    <h3>Reset User Password</h3>

    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <input type="email" name="email" placeholder="User Email" required />
    <input type="password" name="new_password" placeholder="New Password (min 6 chars)" required />
    <button type="submit">Reset Password</button>
     <a href="admin_dashboard.php" class="back-button">← Back to Dashboard</a>
  </form>

</body>
</html>
