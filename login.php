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
</head>
<body>
    <header>
        <a href="home.html" class="logo">QuitZone 🚭</a>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="progress.html">Progress</a></li>
                <li><a href="challenges.html">Challenges</a></li>
                <li><a href="savings.html">Savings</a></li>
                <li><a href="success_stories.html">Success Stories</a></li>
                <li><a href="chatbot.html">Chatbot</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-page">
        <div class="login-container">
            <h2>Login</h2>
            <p style="color: #777; margin-bottom: 20px;">Welcome back! Ready to continue your smoke-free journey? 🌱</p>

            <?php if (!empty($errorMessage)): ?>
                <p class="message-container error"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form id="login-form" action="login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                    <button type="button" id="toggle-password">👁</button>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© 2025 QuitZone - All Rights Reserved</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const togglePassword = document.getElementById("toggle-password");

            togglePassword.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    togglePassword.textContent = "🙈";
                } else {
                    passwordInput.type = "password";
                    togglePassword.textContent = "👁";
                }
            });

            const inputs = [document.getElementById("email"), document.getElementById("username"), passwordInput];
            inputs.forEach(input => {
                input.addEventListener("focus", () => input.style.borderColor = "#ffa7a7");
                input.addEventListener("blur", () => input.style.borderColor = "#ccc");
            });
        });
    </script>
</body>
</html>
