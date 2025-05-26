<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // الاتصال بقاعدة البيانات
    $conn = new mysqli("localhost", "root", "", "quitzone");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // التحقق من وجود البريد الإلكتروني
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // تشفير كلمة المرور الجديدة
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // تحديث كلمة المرور
        $updateStmt = $conn->prepare("UPDATE users SET Password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $email);
        $updateStmt->execute();

        echo "<script>alert('Password has been reset successfully.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Email not found.'); window.location.href='forget_password.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>QuitZone - Login</title>
    <link rel="stylesheet" href="grad.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
 <!-- Header -->
    <header class="navbar">
        <div class="container">
            <a href="home.php" class="logo">
                <span>QuitZone</span>
                <span class="emoji">🚭</span>
            </a>
            
            <!-- Navigation Links for Desktop -->
            <nav class="nav-desktop">
                <ul>
                    
                    <li><a href="login.php" class="login-btn active">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

 <section class="login-page">
    <div class="login-container">
      <div class="login-header">
        <h2>Reset Password</h2>
        <p>Enter your email and new password</p>
      </div>

      <form action="forget_password.php" method="POST">
        <div class="input-group">
          <label for="email"><i class="fas fa-envelope"></i> Email</label>
          <input type="email" id="email" name="email" required />
        </div>

        <div class="input-group">
          <label for="new_password"><i class="fas fa-lock"></i> New Password</label>
          <input type="password" id="new_password" name="new_password" required />
        </div>

        <button type="submit" class="login-btnn" href="login.php">Reset Password</button>
      </form>

      <div class="switch-form">
        <p>Back to <a href="login.php">Login</a></p>

      </div>
    </div>
  </section>
<style>
    .login-page {
    background-image: url('img/happy.png'); /* Relative to the location of login.php */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    min-height: 100vh;
    padding: 80px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

        
      .login-container {
    background-color: rgba(255, 255, 255, 0.95); /* Light white background for contrast */
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}
.switch-form {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.switch-form a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: 500;
}

.switch-form a:hover {
    text-decoration: underline;
}

        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
      
        .message-container {
            padding: 1rem;
            margin: 1rem 0 2rem;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .message-container.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .message-container.success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .message-container i {
            font-size: 1.5rem;
        }
        
        .message-container p {
            margin: 0;
        }
        
        .login-tabs {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }
        
        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: width 0.3s;
        }
        
        .tab-btn.active {
            color: var(--accent);
        }
        
        .tab-btn.active::after {
            width: 100%;
        }
        
        .tab-content {
            margin-bottom: 2rem;
        }
        
        .tab-pane {
            display: none;
        }
        
        .tab-pane.active {
            display: block;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .input-group label i {
            color: var(--primary);
        }
        
        .input-group input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius-sm);
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 1rem;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 126, 145, 0.1);
        }
        
        .input-group.focused label {
            color: var(--primary);
        }
        
        .password-field {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .toggle-password:hover {
            color: var(--accent);
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 1.5rem;
        }
        
        .forgot-password a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .forgot-password a:hover {
            color: var(--accent);
            text-decoration: underline;
        }
        
        .login-btnn {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(244, 107, 142, 0.2);
        }
        
        .social-login {
            margin-top: 2rem;
        }
        
        .divider {
            position: relative;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #eee;
        }
        
        .divider span {
            position: relative;
            background-color: white;
            padding: 0 1rem;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .social-btn {
            padding: 0.8rem;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: white;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .social-btn.google {
            background-color: #DB4437;
        }
        
        .social-btn.facebook {
            background-color: #4267B2;
        }
        
        .terms-agreement {
            margin-bottom: 1.5rem;
        }
        
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--text-light);
            line-height: 1.5;
        }
        
        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            position: absolute;
            top: 2px;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #f1f1f1;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .checkbox-container:hover .checkmark {
            background-color: #e0e0e0;
        }
        
        .checkbox-container input:checked ~ .checkmark {
            background-color: var(--primary);
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }
        
        .checkbox-container .checkmark:after {
            left: 7px;
            top: 3px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .terms-agreement a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .terms-agreement a:hover {
            text-decoration: underline;
        }
        
        .login-features {
            display: flex;
            justify-content: space-around;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .feature i {
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .feature span {
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
            }
            
            .login-features {
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .feature {
                width: 100%;
                flex-direction: row;
                justify-content: center;
            }
        }
    </style>
<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="home.php">
                        <span>QuitZone</span>
                        <span class="emoji">🚭</span>
                    </a>
                    <p>Your partner in the journey to a smoke-free life.</p>
                </div>
                
                <div class="footer-links">
                    <div class="footer-column">
                        <h3>Pages</h3>
                        <ul>
                            <li><a href="home.php">Home</a></li>
                            <li><a href="progress.php">Progress</a></li>
                            <li><a href="challenges.php">Challenges</a></li>
                            <li><a href="savings.php">Savings</a></li>
                            <li><a href="success_stories.php">Success Stories</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h3>Connect</h3>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 QuitZone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- External JS -->
    <script src="common.js"></script>
</body>
</html>