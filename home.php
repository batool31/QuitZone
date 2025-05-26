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
  <a href="login.php" class="start-btn"><span>Get Started</span></a>
  <a href="awareness.php" class="start-btn secondary"><span>Learn More</span></a>
</div>


    <p class="quote" data-aos="fade-up" data-aos-delay="700">
      "Every cigarette you don't smoke is a step towards a healthier life!"
    </p>
  </div>

  </section>


  <section class="progress-stats">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">Your Smoke-Free Progress</h2>

      <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
        <div class="stats-grid">
          <div class="stat-box" data-aos="fade-right" data-aos-delay="400">
            <div class="decoration-circle"></div>
            <p class="stat-label"><i class="fas fa-calendar-alt"></i> Quit Date:</p>
            <p id="quit-date" class="stat-value">January 1, 2025</p>

            <p class="stat-label"><i class="fas fa-hourglass-half"></i> Time Smoke-Free:</p>
            <p class="stat-value">
              <span id="days-free" class="counter" data-target="124">0</span>
              <span class="time-unit">d </span>
              <span class="time-unit">12h </span>
              <span class="time-unit">45m </span>
              <span class="time-unit">30s</span>
            </p>
          </div>

          <div class="stat-box" data-aos="fade-left" data-aos-delay="600">
            <div class="decoration-circle circle-alt"></div>
            <p class="stat-label"><i class="fas fa-coins"></i> Money Saved:</p>
            <p class="stat-value">$<span id="money-saved" class="counter" data-target="1245.50">0.00</span></p>

            <p class="stat-label"><i class="fas fa-heartbeat"></i> Health Improved:</p>
            <p id="health-benefit" class="stat-value">Lung function improved 🫁</p>
          </div>
        </div>

       <div class="progress-section" data-aos="fade-up" data-aos-delay="800">
  <p class="stat-label">Your Milestones:</p>
  <div class="progress-bar-container1">
    <div id="progress-bar" class="progress-bar" style="width: 50%">
    </div>

    <div class="milestone-markers">
      <span class="milestone" style="left: 10%">1d</span>
      <span class="milestone" style="left: 30%">1w</span>
      <span class="milestone" style="left: 50%">1m</span>
      <span class="milestone" style="left: 70%">3m</span>
      <span class="milestone" style="left: 90%">1y</span>
    </div>
  </div>
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
        <a href="login.php" class="start-btn2"><span>Take the Test</span></a>
        <a href="success_stories.php" class="start-btn2 secondary"><span>Be Inspired by Real Success Stories</span></a>
      </div>
    </div>
  </div>
</section>
  <section class="features">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">How QuitZone Helps You Quit</h2>
      <p class="section-description" data-aos="fade-up" data-aos-delay="200">
        Our comprehensive tools and resources are designed to support every aspect of your quit journey
      </p>

      <div class="features-grid">
        <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <h3>Track Your Progress</h3>
          <p>
            Monitor your smoke-free days, health improvements, and money saved in real-time.
          </p>
        </div>

        <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
          <div class="feature-icon">
            <i class="fas fa-trophy"></i>
          </div>
          <h3>Complete Challenges</h3>
          <p>
            Stay motivated with daily, weekly, and monthly challenges to conquer cravings.
          </p>
        </div>

        <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
          <div class="feature-icon">
            <i class="fas fa-piggy-bank"></i>
          </div>
          <h3>Calculate Savings</h3>
          <p>
            See how much money you're saving and plan what to do with your newfound wealth.
          </p>
        </div>

        <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
          <div class="feature-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3>Community Support</h3>
          <p>
            Connect with fellow quitters, share experiences, and celebrate victories together.
          </p>
        </div>

        <div class="feature-card" data-aos="fade-up" data-aos-delay="700">
          <div class="feature-icon">
            <i class="fas fa-brain"></i>
          </div>
          <h3>Smart AI Assistant</h3>
          <p>
            Get personalized advice and support when cravings strike, 24/7.
          </p>
        </div>

        <div class="feature-card" data-aos="fade-up" data-aos-delay="800">
          <div class="feature-icon">
            <i class="fas fa-heartbeat"></i>
          </div>
          <h3>Health Insights</h3>
          <p>
            Understand how your body is healing with day-by-day health improvement data.
          </p>
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

    // Counter animation function
    function animateCounter(element, target, duration = 2000) {
      let start = 0;
      const increment = target / (duration / 16);

      const updateCounter = () => {
        start += increment;

        if (start < target) {
          if (Number.isInteger(target)) {
            element.textContent = Math.floor(start).toLocaleString();
          } else {
            element.textContent = start.toFixed(2);
          }
          requestAnimationFrame(updateCounter);
        } else {
          if (Number.isInteger(target)) {
            element.textContent = target.toLocaleString();
          } else {
            element.textContent = target.toFixed(2);
          }
        }
      };

      // Observe element visibility before starting animation
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            updateCounter();
            observer.unobserve(entry.target); // Stop observing once animated
          }
        });
      }, { threshold: 0.5 }); // Trigger when 50% of element is visible


      // Start animation after a slight delay if already in view or observe
      // Check if element is already in viewport on load
      if (isInViewport(element)) {
         setTimeout(() => {
            updateCounter();
          }, 500); // Slight delay even if in view
      } else {
         observer.observe(element);
      }
    }

    // Check if element is in viewport (helper function for initial check)
    function isInViewport(element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }


    // Animate counters when they come into view
    document.addEventListener('DOMContentLoaded', () => {
      const counters = document.querySelectorAll('.counter');

      counters.forEach(counter => {
        const targetValue = parseFloat(counter.getAttribute('data-target'));
        counter.textContent = '0'; // Initialize to 0

        // Use the updated animateCounter with observer
        animateCounter(counter, targetValue);
      });
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

  </script>
  <script src="common.js"></script>
</body>
</html>
