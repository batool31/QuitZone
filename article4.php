<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'data.Base.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuitZone - Benefits of Quitting</title>
    <link rel="stylesheet" href="grad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="navbar">
        <div class="container">
            <a href="home.php" class="logo">
                <span>QuitZone</span>
                <span class="emoji">🚭</span>
            </a>
            <nav class="nav-desktop">
                <ul>
                    <li><a href="home.php" class="nav-link">Home</a></li>
                    <li><a href="awareness.php" class="nav-link ">Awareness</a></li>
                    <li><a href="progress.php" class="nav-link">Progress</a></li>
                    <li><a href="challenges.php" class="nav-link">Challenges</a></li>
                    <li><a href="savings.php" class="nav-link">Savings</a></li>
                    <li><a href="success_stories.php" class="nav-link">Success Stories</a></li>
                    <li><a href="chatbot.php" class="nav-link">Chatbot</a></li>
                    <li><a href="login.php" class="login-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <article class="article">
            <header class="article-header">
                <h1>Tips for Slips</h1>
                <p class="article-lead">Many smokers slip and smoke a cigarette while they’re quitting smoking. You’re not alone. Don’t use a slip as an excuse to start smoking again.</p>
            </header>

            <section class="article-content">
                <img src="img/ctrl.png" alt="Health Benefits Diagram" class="article-image">

                <p>If you slip, you might try these ways to get back on track:</p>

                <p>&#8226; Slips are common so don’t be too hard on yourself. A slip doesn’t make you a failure or mean you're relapsing. It doesn’t mean you can’t quit for good.</p>
                <p>&#8226; Feel proud of the time you went without smoking cigarettes. Think about ways you avoided your triggers and beat cravings. Try to use those ways to cope again.</p>
                <p>&#8226; It’s important to restart quitting right away—today or tomorrow at the latest. Don’t give up on your goal of no cigarettes at all.</p>
                <p>&#8226; If quitting forever seems too hard right now, try a text message program to help you prepare to quit in the future. These programs help you build skills for dealing with cravings, triggers, and stressful situations. You can try a Practice Quit for a few days or do a week of Daily Challenges without quitting.</p>
                <p>&#8226; Use nicotine replacement therapy (NRT). You don’t need to stop using NRT after you slip and smoke one or two cigarettes. Using NRT increases your chances of staying smokefree for good. </p>
                <p>&#8226; Get support. If you slip, talk to family or friends. Ask them for help to stay smokefree. You don’t have to do it alone.</p>
                <p>&#8226; Think about what you learned when you were not smoking. What helped you to stay smokefree and what caused you to have a slip? What can you do differently now to help yourself be smokefree again?</p>
            </section>
        </article>
    </main>

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

    <script src="common.js"></script>
</body>
</html>
