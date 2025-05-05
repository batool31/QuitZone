<?php
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "quitzone";

    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Should match registration hash

    // Update table name from 'users' to 'login'
    $sql = "SELECT * FROM login WHERE email='$email' AND username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Redirect to the welcome page on successful login
    if ($result->num_rows > 0) {
        header("Location: welcome.html");  // Redirect to the welcoming page
        exit();
    } else {
        $errorMessage = "❌ Invalid credentials. Try again.";
    }

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
    <header class="navbar">
        <div class="container">
            <a href="home.html" class="logo">
                <span>QuitZone</span>
                <span class="emoji">🚭</span>
            </a>
            
            <!-- Mobile menu button -->
            <button class="mobile-menu-btn" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Navigation Links for Desktop -->
            <nav class="nav-desktop">
                <ul>
                    <li><a href="home.html" class="nav-link">Home</a></li>
                    <li><a href="progress.html" class="nav-link">Progress</a></li>
                    <li><a href="challenges.html" class="nav-link">Challenges</a></li>
                    <li><a href="savings.html" class="nav-link">Savings</a></li>
                    <li><a href="success_stories.html" class="nav-link">Success Stories</a></li>
                    <li><a href="chatbot.html" class="nav-link">Chatbot</a></li>
                    <li><a href="login.php" class="login-btn">Login</a></li>
                </ul>
            </nav>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="progress.html">Progress</a></li>
                <li><a href="challenges.html">Challenges</a></li>
                <li><a href="savings.html">Savings</a></li>
                <li><a href="success_stories.html">Success Stories</a></li>
                <li><a href="chatbot.html">Chatbot</a></li>
                <li><a href="login.php" class="mobile-login-btn">Login</a></li>
            </ul>
        </div>
        
        <!-- Menu Overlay -->
        <div class="menu-overlay"></div>
    </header>

    <section class="login-page">
        <div class="login-container" data-aos="fade-up">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Ready to continue your smoke-free journey? 🌱</p>
            </div>

            <?php if (!empty($errorMessage)): ?>
                <div class="message-container error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo $errorMessage; ?></p>
                </div>
            <?php endif; ?>

            <div class="login-tabs">
                <button class="tab-btn active" data-tab="login">Login</button>
                <button class="tab-btn" data-tab="register">Register</button>
            </div>

            <div class="tab-content">
                <div id="login-tab" class="tab-pane active">
                    <form id="login-form" action="login.php" method="POST">
                        <div class="input-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required />
                        </div>
                        
                        <div class="input-group">
                            <label for="username">
                                <i class="fas fa-user"></i> Username
                            </label>
                            <input type="text" id="username" name="username" required />
                        </div>
                        
                        <div class="input-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <div class="password-field">
                                <input type="password" id="password" name="password" required />
                                <button type="button" id="toggle-password" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="forgot-password">
                            <a href="#">Forgot Password?</a>
                        </div>
                        
                        <button type="submit" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>
                    
                    <div class="social-login">
                        <div class="divider">
                            <span>OR</span>
                        </div>
                        
                        <div class="social-buttons">
                            <button class="social-btn google">
                                <i class="fab fa-google"></i> Login with Google
                            </button>
                            <button class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i> Login with Facebook
                            </button>
                        </div>
                    </div>
                </div>
                
                <div id="register-tab" class="tab-pane">
                    <form id="register-form">
                        <div class="input-group">
                            <label for="reg-name">
                                <i class="fas fa-user"></i> Full Name
                            </label>
                            <input type="text" id="reg-name" name="name" required />
                        </div>
                        
                        <div class="input-group">
                            <label for="reg-email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="reg-email" name="email" required />
                        </div>
                        
                        <div class="input-group">
                            <label for="reg-username">
                                <i class="fas fa-user-circle"></i> Username
                            </label>
                            <input type="text" id="reg-username" name="username" required />
                        </div>
                        
                        <div class="input-group">
                            <label for="reg-password">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <div class="password-field">
                                <input type="password" id="reg-password" name="password" required />
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="reg-confirm-password">
                                <i class="fas fa-lock"></i> Confirm Password
                            </label>
                            <div class="password-field">
                                <input type="password" id="reg-confirm-password" name="confirm-password" required />
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="terms-agreement">
                            <label class="checkbox-container">
                                <input type="checkbox" required />
                                <span class="checkmark"></span>
                                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="login-btn">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="login-features">
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure Login</span>
                </div>
                <div class="feature">
                    <i class="fas fa-history"></i>
                    <span>Save Progress</span>
                </div>
                <div class="feature">
                    <i class="fas fa-trophy"></i>
                    <span>Track Achievements</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <svg class="footer-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffe1e1" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,181.3C960,181,1056,203,1152,208C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="home.html">
                        <span>QuitZone</span>
                        <span class="emoji">🚭</span>
                    </a>
                </div>
                
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                <div class="footer-nav">
                    <a href="home.html">Home</a>
                    <a href="progress.html">Progress</a>
                    <a href="challenges.html">Challenges</a>
                    <a href="savings.html">Savings</a>
                    <a href="success_stories.html">Success Stories</a>
                    <a href="chatbot.html">Chatbot</a>
                </div>
                
                <div class="copyright">
                    <p>© 2025 QuitZone - All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileMenu = document.querySelector('.mobile-menu');
            const menuOverlay = document.querySelector('.menu-overlay');
            
            if (mobileMenuBtn && mobileMenu && menuOverlay) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('open');
                    menuOverlay.classList.toggle('open');
                    
                    const icon = mobileMenuBtn.querySelector('i');
                    if (icon) {
                        if (icon.classList.contains('fa-bars')) {
                            icon.classList.remove('fa-bars');
                            icon.classList.add('fa-times');
                        } else {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
                
                menuOverlay.addEventListener('click', function() {
                    mobileMenu.classList.remove('open');
                    menuOverlay.classList.remove('open');
                    
                    const icon = mobileMenuBtn.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Login/Register tab switching
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabBtns.forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('active');
                    });
                    
                    // Show the selected tab pane
                    const tab = this.getAttribute('data-tab');
                    document.getElementById(`${tab}-tab`).classList.add('active');
                });
            });
            
            // Password visibility toggle
            const toggleButtons = document.querySelectorAll('.toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
            
            // Input focus effect
            const inputs = document.querySelectorAll('.input-group input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
                
                // Check if input has value on page load
                if (input.value) {
                    input.parentElement.classList.add('focused');
                }
            });
            
            // Register form submission (placeholder)
            const registerForm = document.getElementById('register-form');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const password = document.getElementById('reg-password').value;
                    const confirmPassword = document.getElementById('reg-confirm-password').value;
                    
                    if (password !== confirmPassword) {
                        alert('Passwords do not match.');
                        return;
                    }
                    
                    // This is a placeholder - in a real implementation, you'd submit to a server
                    alert('Registration successful! Please log in with your new credentials.');
                    
                    // Switch to login tab
                    document.querySelector('.tab-btn[data-tab="login"]').click();
                });
            }
        });
    </script>
    
    <style>
        /* Additional Styles for Login Page */
        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 150px);
            padding: 6rem 1rem 3rem;
            background: linear-gradient(135deg, rgba(255, 225, 225, 0.3), rgba(224, 234, 252, 0.3));
        }
        
        .login-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
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
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .login-header p {
            color: var(--text-light);
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
        
        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
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
</body>
</html>