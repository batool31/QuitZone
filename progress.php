<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'data.Base.php';
$user_id = $_SESSION['user_id'];

// جلب الأهداف
$goals_stmt = $conn->prepare("SELECT * FROM user_goals WHERE user_id = ?");
if (!$goals_stmt) {
    die("Prepare failed: " . $conn->error);
}
$goals_stmt->bind_param("i", $user_id);
$goals_stmt->execute();
$goals_result = $goals_stmt->get_result();
$goals = $goals_result->fetch_all(MYSQLI_ASSOC);

// جلب الإنجازات
$milestones_stmt = $conn->prepare("SELECT * FROM user_milestones WHERE user_id = ?");
if (!$milestones_stmt) {
    die("Prepare failed: " . $conn->error);
}
$milestones_stmt->bind_param("i", $user_id);
$milestones_stmt->execute();
$milestones_result = $milestones_stmt->get_result();
$milestones = $milestones_result->fetch_all(MYSQLI_ASSOC);

// إدخال هدف جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_goal'])) {
    $goal_text = trim($_POST['new_goal']);
    $insert_stmt = $conn->prepare("INSERT INTO user_goals (user_id, goal_text) VALUES (?, ?)");
    if (!$insert_stmt) {
        die("Insert Prepare failed: " . $conn->error);
    }
    $insert_stmt->bind_param("is", $user_id, $goal_text);
    $insert_stmt->execute();
    header("Location: progress.php");
    exit;
}

// تحديث إنجاز
if (isset($_POST['milestone_id'])) {
    $milestone_id = intval($_POST['milestone_id']); // تأكد من تحويله إلى int

    $stmt = $conn->prepare("UPDATE user_milestones SET status = 'completed' WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ii", $milestone_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Milestone updated successfully.";
    } else {
        echo "No changes made. Check milestone ID and user ID.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuitZone - Progress</title>
    <link rel="stylesheet" href="grad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
                    <li><a href="home.php" class="nav-link">Home</a></li>
                    <li><a href="awareness.php" class="nav-link">Awareness</a></li>
                    <li><a href="progress.php" class="nav-link active">Progress</a></li>
                    <li><a href="challenges.php" class="nav-link">Challenges</a></li>
                    <li><a href="savings.php" class="nav-link">Savings</a></li>
                    <li><a href="success_stories.php" class="nav-link">Success Stories</a></li>
                    <li><a href="chatbot.php" class="nav-link">Chatbot</a></li>
                 <li><a href="login.php" class="login-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="progress-page">
        <div class="container" style="padding-top: 8rem;">
            <h1 class="section-title" data-aos="fade-up">Health Improvement After Quitting Smoking</h1>

            <div class="side-by-side-container">
                <div class="benefits-section" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="subsection-title">Health Benefits Over Time</h2>
                    <div class="timeline-benefits">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>20 minutes</h3>
                                <p>Heart rate and blood pressure drop.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-lungs"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>12 hours</h3>
                                <p>Carbon monoxide level in blood returns to normal.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>24 hours</h3>
                                <p>Risk of heart attack starts to decrease.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-wind"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>1 week</h3>
                                <p>Breathing improves as lungs start to clear.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>1 month</h3>
                                <p>Lung function improves significantly. Increased energy levels.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>1 year</h3>
                                <p>Risk of heart disease drops by half compared to a smoker.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-section" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="subsection-title">Your Health Improvement</h2>
                    <div class="chart-container">
                        <canvas id="healthChart"></canvas>
                    </div>
                </div>
            </div>
           <div class="goals-section" data-aos="fade-up" data-aos-delay="350">
    <h2 class="subsection-title">Your Personal Goals</h2>
    <div class="goals-container">
        <!-- الأهداف الأساسية -->
        <div class="goal-item">
            <label class="checkbox-container">
                <input type="checkbox">
                <span class="checkmark"></span>
                <span class="goal-text">Go one full day without smoking</span>
            </label>
        </div>
        <div class="goal-item">
            <label class="checkbox-container">
                <input type="checkbox">
                <span class="checkmark"></span>
                <span class="goal-text">Try a new healthy habit to replace smoking</span>
            </label>
        </div>
        <div class="goal-item">
            <label class="checkbox-container">
                <input type="checkbox">
                <span class="checkmark"></span>
                <span class="goal-text">Exercise for 30 minutes three times a week</span>
            </label>
        </div>
        <div class="goal-item">
            <label class="checkbox-container">
                <input type="checkbox">
                <span class="checkmark"></span>
                <span class="goal-text">Reach one month without smoking</span>
            </label>
        </div>
        <div class="goal-item">
            <label class="checkbox-container">
                <input type="checkbox">
                <span class="checkmark"></span>
                <span class="goal-text">Save $500 from not buying cigarettes</span>
            </label>
        </div>

        <!-- أهداف المستخدم من قاعدة البيانات -->
       <?php foreach ($goals as $goal): ?>
    <div class="goal-item">
        <label class="checkbox-container">
            <input type="checkbox"
                   class="goal-checkbox"
                   data-goal-id="<?= $goal['id'] ?>"
                   <?= $goal['is_completed'] ? 'checked' : '' ?>>
            <span class="checkmark"></span>
            <span class="goal-text"><?= htmlspecialchars($goal['goal_text']) ?></span>
        </label>
    </div>
<?php endforeach; ?>

    </div>

    <!-- نموذج إضافة هدف جديد -->
    <form method="POST" action="progress.php" class="add-goal">
        <input type="text" name="new_goal" placeholder="Add a new goal..." required>
        <button class="add-goal-btn" type="submit"><i class="fas fa-plus"></i></button>
    </form>
</div>
 <section class="progress-stats">
<div class="container">
      <h2 class="section-title" data-aos="fade-up">Heba's Progress</h2>

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

        // Health improvement chart
      // Health improvement chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('healthChart').getContext('2d');

    const healthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['20 minutes', '12 hours', '24 hours', '1 week', '1 month', '1 year'],
            datasets: [
                {
                    label: 'Lung Function',
                    data: [30, 35, 40, 60, 85, 95],
                    borderColor: '#37474F',
                    backgroundColor: 'rgba(55, 71, 79, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Heart Health',
                    data: [35, 45, 55, 70, 88, 97],
                    borderColor: '#546E7A',
                    backgroundColor: 'rgba(84, 110, 122, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Energy Levels',
                    data: [25, 30, 35, 55, 80, 90],
                    borderColor: '#78909C',
                    backgroundColor: 'rgba(120, 144, 156, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Health Improvement Metrics'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Health Score (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time Since Quitting'
                    }
                }
            }
        }
    });
});

        // Add new goal functionality
       document.addEventListener('DOMContentLoaded', function() {
            const addGoalBtn = document.querySelector('.add-goal-btn');
            const goalInput = document.querySelector('.add-goal input');
            const goalsContainer = document.querySelector('.goals-container');

            if (addGoalBtn && goalInput && goalsContainer) {
                addGoalBtn.addEventListener('click', function() {
                    const goalText =  goalInput.value.trim();
                    if (goalText) {
                        // Create new goal item
                        const newGoalItem = document.createElement('div');
                        newGoalItem.className = 'goal-item';
                        newGoalItem.innerHTML = `
                            <label class="checkbox-container">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span class="goal-text">${goalText}</span>
                            </label>
                        `;

                        // Insert before the add goal section
                        goalsContainer.insertBefore(newGoalItem, document.querySelector('.add-goal'));

                        // Clear input
                        goalInput.value = '';
                    }
                });

                // Add ability to press Enter key to add a goal
                goalInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        addGoalBtn.click();
                        e.preventDefault();
                    }
                });
            }
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

</script>

    <script>
        // Scroll to top when page is refreshed
        window.onbeforeunload = function () {
            window.scrollTo(0, 0);
        }

        // Also force scroll to top when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo(0, 0);
        });
    </script>
    <script src="common.js"></script>
</body>
</html>