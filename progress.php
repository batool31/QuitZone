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

.video-card h3 {
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
<div class="video-milestones-section" data-aos="fade-up">
  <h2 class="subsection-title">Your Journey to Quit Smoking</h2>
  <div class="video-milestone-grid">

    <!-- Milestone 1: Day One -->
    <div class="video-card">
      <h3>Day One</h3>
      <img src="thumbs/day1.jpg" alt="Day One" class="video-thumbnail" data-video-url="https://youtu.be/pFFeeZLHL6U?t=5">
      <p>"The first day is the beginning of everything!"</p>
    </div>

    <!-- Milestone 2: One Week -->
    <div class="video-card">
      <h3>One Week</h3>
      <img src="thumbs/week1.jpg" alt="One Week" class="video-thumbnail" data-video-url="https://www.youtube.com/watch?v=3E-sT7FWYJQ">
      <p>Your lungs begin to clear... Breathing improves!</p>
    </div>

    <!-- Milestone 3: One Month -->
    <div class="video-card">
      <h3>One Month</h3>
      <img src="thumbs/month1.jpg" alt="One Month" class="video-thumbnail" data-video-url="https://www.youtube.com/watch?v=eNtEeS9NURs">
      <p>Watch Motaz & Mohammad’s success story quitting smoking</p>
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
       // Select all checkboxes with the class 'milestone-checkbox'
// فتح نافذة الفيديو عند النقر على الصورة المصغرة
document.querySelectorAll('.video-thumbnail').forEach(function(thumbnail) {
  thumbnail.addEventListener('click', function() {
    var videoUrl = this.getAttribute('data-video-url');
    var videoFrame = document.getElementById('videoFrame');
    videoFrame.src = videoUrl + "?autoplay=1";
    document.getElementById('videoModal').style.display = 'block';
  });
});

// إغلاق نافذة الفيديو عند النقر على زر الإغلاق
document.querySelector('.close-button').addEventListener('click', function() {
  var videoFrame = document.getElementById('videoFrame');
  videoFrame.src = "";
  document.getElementById('videoModal').style.display = 'none';
});

// إغلاق نافذة الفيديو عند النقر خارج المحتوى
window.addEventListener('click', function(event) {
  var modal = document.getElementById('videoModal');
  if (event.target == modal) {
    var videoFrame = document.getElementById('videoFrame');
    videoFrame.src = "";
    modal.style.display = 'none';
  }
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