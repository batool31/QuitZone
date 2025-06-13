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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>QuitZone - Start Your Smoke-Free Journey</title>
  <link rel="stylesheet" href="grad.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
   .video-milestones-section {
  padding: 60px 20px;
  text-align: center;
}

.video-milestone-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  margin-top: 30px;
}

.video-card {
  background: #f9f9f9;
  border-radius: 15px;
  padding: 15px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  transition: transform 0.3s;
  cursor: pointer;
}

.video-card:hover {
  transform: scale(1.02);
}

.video-card h4 {
  margin-bottom: 10px;
  color: #333;
}

.video-card p {
  font-size: 14px;
  color: #666;
}

.video-thumbnail {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 10px;
}

/* نافذة الفيديو المنبثقة */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.8);
}

.modal-content {
  position: relative;
  margin: 5% auto;
  width: 80%;
  max-width: 800px;
}

.modal-content iframe {
  width: 100%;
  height: 450px;
  border: none;
  border-radius: 10px;
}

.close-button {
  position: absolute;
  top: -10px;
  right: -10px;
  color: #fff;
  font-size: 30px;
  font-weight: bold;
  cursor: pointer;
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
          <li><a href="home.php" class="nav-link active ">Home</a></li>
          <li><a href="awareness.php" class="nav-link">Awareness</a></li>
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

<section class="hero">
  <div class="bg-elements">
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>
    <div class="bg-circle circle-3"></div>
  </div>

  <div class="hero-content">
    <h2 class="subtitle" data-aos="fade-down" data-aos-delay="100">
      Welcome to <span class="highlight">QuitZone <span class="wave">👋</span></span>
    </h2>

    <h1 class="title" data-aos="fade-up" data-aos-delay="200">
      Start Your Journey to a Smoke-Free Life
    </h1>

   <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
  <a href="progress.php" class="start-btn"><span>Stay on Track</span></a>
  <a href="awareness.php" class="start-btn secondary"><span>Learn More</span></a>
</div>


    <p class="quote" data-aos="fade-up" data-aos-delay="700">
      "Every cigarette you don't smoke is a step towards a healthier life!"
    </p>
  </div>

  </section>
  
<section class="awareness-section">
  <h2 class="section-title" data-aos="fade-up">Why Quit Smoking?</h2>
  <div class="awareness-container">
    <div class="awareness-box" data-aos="fade-up" data-aos-delay="200">
      <img src="img/betheath.jpg" alt="Health Icon" class="awareness-icon" />

      <h3>Better Health</h3>
      <p>Quitting smoking significantly reduces the risk of heart disease, stroke, and cancer.</p>
      <a href="progress.php" class="awareness-btn">Track Your Progress</a>
    </div>

    <div class="awareness-box" data-aos="fade-up" data-aos-delay="300">
      <img src="img/savem.png" alt="Money Icon" class="awareness-icon" />
      <h3>Save Money</h3>
      <p>Smoking is expensive. Quitting can save you thousands every year.</p>
      <a href="savings.php" class="awareness-btn">View Your Savings</a>
    </div>

    <div class="awareness-box" data-aos="fade-up" data-aos-delay="400">
      <img src="img/clear.png" alt="Clean Air Icon" class="awareness-icon" />
      <h3>Clean Environment</h3>
      <p>Secondhand smoke harms those around you. Quitting helps protect others too.</p>
       <a href="awareness.php" class="awareness-btn">Learn More</a>
    </div>
  </div>
</section>

 <section class="features">
      
<div class="video-milestones-section" data-aos="fade-up">
  <h2 class="section-title">Understand. Decide. Heal.</h2>
  <div class="video-milestone-grid">

    <!-- Milestone 1: Day One -->
    <div class="video-card">
      <h4>What Happens 20 Minutes After You Quit?</h4>
      <img src="img/sh.png" alt="Day One" class="video-thumbnail" data-video-url="https://www.youtube.com/embed/pFFeeZLHL6U">
      <p>"Your heart, your blood, your body—all respond fast. Watch how."</p>
    </div>

    <!-- Milestone 2: One Week -->
    <div class="video-card">
      <h4>The Hidden Damage of Smoking</h4>
      <img src="img/abu.png" alt="One Week" class="video-thumbnail" data-video-url="https://www.youtube.com/embed/DPOKaVpNO3Y">
      <p>"A visual warning of what’s happening inside with every cigarette."</p>
    </div>

    <!-- Milestone 3: One Month -->
    <div class="video-card">
      <h4>Quitting for Your Family</h4>
      <img src="img/baby.png" alt="One Month" class="video-thumbnail" data-video-url="https://www.youtube.com/embed/f_Auh61aN9Y">
      <p>"See how your choices affect the next generation."</p>
    </div>

  </div>
</div>

<!-- Video Popup Modal -->
<div id="videoModal" class="modal">
  <div class="modal-content">
    <span class="close-button">&times;</span>
    <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
  </div>
</div>
  </section>

<section class="interactive-test">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">🎯 Interactive Test: "Are you ready to quit?"</h2>
    <p class="section-description" data-aos="fade-up" data-aos-delay="200">
      Answer a few quick questions to assess your physical and psychological readiness to quit smoking.
    </p>

    <div class="test-card" data-aos="zoom-in" data-aos-delay="400">
      <p class="test-info">
        Based on your answers, you'll get one of the following recommendations:
      </p>
      <ul class="test-recommendations">
        <li>✅ <strong>Start today</strong></li>
        <li>🛠️ <strong>Improve your readiness with these steps</strong></li>
      </ul>
      <div class="test-buttons">
        <a href="test.php" class="start-btn2"><span>Take the Test</span></a>
        <a href="success_stories.php" class="start-btn2 secondary"><span>Be Inspired by Real Success Stories</span></a>
      </div>
    </div>
  </div>
</section>
 
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
            <div class="newsletter">
              <h3>Stay Updated</h3>
              <form class="newsletter-form">
                <input type="email" placeholder="Your email address">
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; 2025 QuitZone. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });

    // Scroll to top when page is refreshed
    window.onbeforeunload = function () {
      window.scrollTo(0, 0);
    }

    // Also force scroll to top when the page loads
    document.addEventListener('DOMContentLoaded', function() {
      window.scrollTo(0, 0);
    });

    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) { // Adjust scroll threshold as needed
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
      
document.querySelectorAll('.video-thumbnail').forEach(thumbnail => {
  thumbnail.addEventListener('click', function () {
    const videoUrl = this.getAttribute('data-video-url') + '?autoplay=1';
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');

    iframe.src = videoUrl;
    modal.style.display = 'block';
  });
});

// Close modal
document.querySelector('.close-button').addEventListener('click', function () {
  const modal = document.getElementById('videoModal');
  const iframe = document.getElementById('videoFrame');
  
  iframe.src = ''; // Stop video
  modal.style.display = 'none';
});

// Close modal when clicking outside the modal content
window.addEventListener('click', function (e) {
  const modal = document.getElementById('videoModal');
  const content = document.querySelector('.modal-content');
  if (e.target === modal) {
    document.getElementById('videoFrame').src = '';
    modal.style.display = 'none';
  }
});
  </script>
  <script src="common.js"></script>
</body>
</html>
