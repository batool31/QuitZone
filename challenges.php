<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'data.Base.php';

$user_id = $_SESSION['user_id'];

// معالجة إضافة تحدي جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_challenge'])) {
    $title = trim($_POST['challenge_title']);
    $description = trim($_POST['challenge_description']);
    $type = $_POST['challenge_type'];
    $duration = intval($_POST['challenge_duration']);
    
    if (!empty($title) && !empty($description) && !empty($type) && $duration > 0) {
        try {
            $query = "INSERT INTO challenges (user_id, title, description, type, duration, is_default) VALUES (?, ?, ?, ?, ?, 0)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssi", $user_id, $title, $description, $type, $duration);
            
            if ($stmt->execute()) {
                $success_message = "Challenge added successfully!";
            } else {
                $error_message = "Error adding challenge. Please try again.";
            }
        } catch (Exception $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    } else {
        $error_message = "Please fill in all fields correctly.";
    }
}

// دالة لحساب النقاط حسب النوع
function getPointsByType($type) {
    switch($type) {
        case 'daily': return 15;
        case 'weekly': return 50; 
        case 'monthly': return 200;
        default: return 10;
    }
}

// جلب التحديات من قاعدة البيانات وحفظها في متغيرات
$dbChallenges = [];

try {
    // التحديات الافتراضية
    $query = "SELECT * FROM challenges WHERE is_default = 1 AND user_id IS NULL ORDER BY type, id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($challenge = $result->fetch_assoc()) {
        $dbChallenges[] = $challenge;
    }

    // التحديات الخاصة بالمستخدم
    $query = "SELECT * FROM challenges WHERE user_id = ? ORDER BY type, id";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($challenge = $result->fetch_assoc()) {
        $dbChallenges[] = $challenge;
    }
} catch (Exception $e) {
    // في حالة خطأ في قاعدة البيانات
    $dbChallenges = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>QuitZone - Challenges</title>
    <link rel="stylesheet" href="grad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
    /* Add Challenge Form Styles */
    .add-challenge-section {
        background: white;
      
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
        margin-bottom: 3rem;
        color: white;
    }

    .add-challenge-form {
        display: grid;
        gap: 1.5rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 600;
        color:#d46b60;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.75rem;
       
        border-radius: 10px;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.9);
        color: #333;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .add-challenge-btn {
       background: linear-gradient(to right, var(--primary), var(--secondary));
        color:white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .add-challenge-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(238, 90, 36, 0.3);
    }

    .message {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: 500;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .add-challenge-section {
            padding: 1.5rem;
        }
    }
    </style>
</head>
<body>
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
                    <li><a href="home.php" class="nav-link">Home</a></li>
                    <li><a href="awareness.php" class="nav-link">Awareness</a></li>
                    <li><a href="progress.php" class="nav-link">Progress</a></li>
                    <li><a href="challenges.php" class="nav-link active">Challenges</a></li>
                    <li><a href="savings.php" class="nav-link">Savings</a></li>
                    <li><a href="success_stories.php" class="nav-link">Success Stories</a></li>
                    <li><a href="chatbot.php" class="nav-link">Chatbot</a></li>
                        <li><a href="login.php" class="login-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <section class="challenges-page">
        <div class="container" style="padding-top: 8rem;">
            <h1 class="section-title" data-aos="fade-up">Quit Smoking Challenges</h1>
            <p class="section-description" data-aos="fade-up" data-aos-delay="200">
                Complete these challenges to stay motivated and build healthy habits on your smoke-free journey
            </p>

            <!-- Current Streak -->
            <div class="streak-section" data-aos="fade-up" data-aos-delay="400">
                <div class="streak-card">
                    <div class="streak-info">
                        <h3>Your Current Streak</h3>
                        <div class="streak-count">
                            <span id="streak-days">14</span>
                            <span class="streak-label">days</span>
                        </div>
                        <p>Keep going! You're doing great!</p>
                    </div>
                    <div class="streak-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </div>

            <!-- Challenges Categories -->
            <div class="challenges-categories" data-aos="fade-up" data-aos-delay="300">
                <button class="category-btn active" data-category="all">All Challenges</button>
                <button class="category-btn" data-category="daily">Daily</button>
                <button class="category-btn" data-category="weekly">Weekly</button>
                <button class="category-btn" data-category="monthly">Monthly</button>
                <button class="category-btn" data-category="completed">Completed</button>
            </div>

            <!-- Challenge Cards -->
            <div class="challenges-grid" id="challenges-container">
                
                <!-- التحديات من قاعدة البيانات -->
                <?php foreach ($dbChallenges as $index => $challenge): ?>
                    <?php $points = getPointsByType($challenge['type']); ?>
                    <div class="challenge-card <?php echo htmlspecialchars($challenge['type']); ?>" data-aos="fade-up" data-aos-delay="<?php echo 500 + ($index * 50); ?>">
                        <div class="challenge-header">
                            <span class="challenge-type <?php echo htmlspecialchars($challenge['type']); ?>">
                                <?php echo ucfirst(htmlspecialchars($challenge['type'])); ?>
                            </span>
                            <span class="challenge-points">+<?php echo $points; ?> pts</span>
                        </div>
                        <h3 class="challenge-title"><?php echo htmlspecialchars($challenge['title']); ?></h3>
                        <p class="challenge-description"><?php echo nl2br(htmlspecialchars($challenge['description'])); ?></p>
                        <div class="challenge-progress">
                            <div class="progress-label">
                                <span>Progress</span>
                                <span>0/<?php echo intval($challenge['duration']); ?></span>
                            </div>
                            <div class="progress-bar-container mini">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                        <label class="checkbox-container">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            Mark as completed
                        </label>
                    </div>
                <?php endforeach; ?>

                <!-- Daily Challenge 1 -->
                <div class="challenge-card daily" data-aos="fade-up" data-aos-delay="500">
                    <div class="challenge-header">
                        <span class="challenge-type daily">Daily</span>
                        <span class="challenge-points">+15 pts</span>
                    </div>
                    <h3 class="challenge-title">Morning Hydration</h3>
                    <p class="challenge-description">Drink a full glass of water first thing in the morning instead of reaching for a cigarette.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/1</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Daily Challenge 2 -->
                <div class="challenge-card daily" data-aos="fade-up" data-aos-delay="550">
                    <div class="challenge-header">
                        <span class="challenge-type daily">Daily</span>
                        <span class="challenge-points">+10 pts</span>
                    </div>
                    <h3 class="challenge-title">Deep Breathing</h3>
                    <p class="challenge-description">Practice deep breathing for 5 minutes when you feel a craving.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/1</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Weekly Challenge 1 -->
                <div class="challenge-card weekly" data-aos="fade-up" data-aos-delay="600">
                    <div class="challenge-header">
                        <span class="challenge-type weekly">Weekly</span>
                        <span class="challenge-points">+50 pts</span>
                    </div>
                    <h3 class="challenge-title">Exercise Routine</h3>
                    <p class="challenge-description">Complete at least 3 workouts this week (minimum 30 minutes each).</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/3</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Weekly Challenge 2 -->
                <div class="challenge-card weekly" data-aos="fade-up" data-aos-delay="650">
                    <div class="challenge-header">
                        <span class="challenge-type weekly">Weekly</span>
                        <span class="challenge-points">+75 pts</span>
                    </div>
                    <h3 class="challenge-title">Healthy Meal Prep</h3>
                    <p class="challenge-description">Prepare at least 5 healthy meals at home this week.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/5</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Monthly Challenge 1 -->
                <div class="challenge-card monthly" data-aos="fade-up" data-aos-delay="700">
                    <div class="challenge-header">
                        <span class="challenge-type monthly">Monthly</span>
                        <span class="challenge-points">+200 pts</span>
                    </div>
                    <h3 class="challenge-title">New Hobby</h3>
                    <p class="challenge-description">Start a new hobby that keeps your hands busy for at least 30 minutes a day.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/30</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Monthly Challenge 2 -->
                <div class="challenge-card monthly" data-aos="fade-up" data-aos-delay="750">
                    <div class="challenge-header">
                        <span class="challenge-type monthly">Monthly</span>
                        <span class="challenge-points">+250 pts</span>
                    </div>
                    <h3 class="challenge-title">Journaling</h3>
                    <p class="challenge-description">Write in a journal daily about your quit journey and feelings for 30 days.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/30</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <!-- Additional challenges -->
                <div class="challenge-card daily" data-aos="fade-up" data-aos-delay="800">
                    <div class="challenge-header">
                        <span class="challenge-type daily">Daily</span>
                        <span class="challenge-points">+20 pts</span>
                    </div>
                    <h3 class="challenge-title">Mindful Walking</h3>
                    <p class="challenge-description">Take a 10-minute mindful walk outside when you feel stressed instead of smoking.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/1</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>

                <div class="challenge-card weekly" data-aos="fade-up" data-aos-delay="850">
                    <div class="challenge-header">
                        <span class="challenge-type weekly">Weekly</span>
                        <span class="challenge-points">+60 pts</span>
                    </div>
                    <h3 class="challenge-title">Social Support</h3>
                    <p class="challenge-description">Connect with friends or family members who support your quit journey at least 3 times this week.</p>
                    <div class="challenge-progress">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>0/3</span>
                        </div>
                        <div class="progress-bar-container mini">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    <label class="checkbox-container">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        Mark as completed
                    </label>
                </div>
            </div>

            <!-- Add Challenge Section - في آخر الصفحة -->
            <div class="add-challenge-section" data-aos="fade-up" data-aos-delay="900">
                <h2 style="text-align: center; margin-bottom: 2rem; font-size: 2rem;">
                    <i class="fas fa-plus-circle"></i> Create your own challenge
                </h2>
                
                <!-- Messages -->
                <?php if (isset($success_message)): ?>
                    <div class="message success-message" data-aos="fade-up">
                        <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                    <div class="message error-message" data-aos="fade-up">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="add-challenge-form">
                    <div class="form-group">
                        <label for="challenge_title">
                            <i class="fas fa-heading"></i> Challenge title
                        </label>
                        <input type="text" id="challenge_title" name="challenge_title" 
                               placeholder="Enter the challenge title" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="challenge_description">
                            <i class="fas fa-align-left"></i> Description of the challenge
                        </label>
                        <textarea id="challenge_description" name="challenge_description" 
                                  placeholder="Describe the challenge in detail" required maxlength="500"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="challenge_type">
                                <i class="fas fa-tag"></i> Challenge type
                            </label>
                            <select id="challenge_type" name="challenge_type" required>
                                <option value="">Choose the type</option>
                                <option value="daily">Daily (+15 points)</option>
                                <option value="weekly"> Weekly (+15 points)</option>
                                <option value="monthly">Monthly (+15 points)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="challenge_duration">
                                <i class="fas fa-clock"></i> Duration
                            </label>
                            <input type="number" id="challenge_duration" name="challenge_duration" 
                                   placeholder="Duration (days/times)" required min="1" max="365">
                        </div>
                    </div>

                    <button type="submit" name="add_challenge" class="add-challenge-btn">
                        <i class="fas fa-plus"></i> Add the challenge
                    </button>
                </form>
            </div>
        </div>
    </section>
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


    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Scroll management
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }

    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo(0, 0);
        initializeCategoryFilters();
        initializeChallengeCompletion();
        
        // Auto hide messages after 5 seconds
        const messages = document.querySelectorAll('.message');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                setTimeout(() => {
                    message.remove();
                }, 300);
            }, 5000);
        });
    });

    // Celebration effect
    function createCelebration(title) {
        let container = document.querySelector('.celebration-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'celebration-container';
            container.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                pointer-events: none;
                z-index: 9999;
            `;
            document.body.appendChild(container);
        }
        
        // Create confetti
        const colors = ['#FFD700', '#FF6347', '#00CED1', '#9370DB', '#32CD32', '#FF69B4'];
        const confettiCount = 150;
        
        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.cssText = `
                position: absolute;
                width: ${Math.random() * 10 + 5}px;
                height: ${Math.random() * 10 + 5}px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                left: ${Math.random() * 100}vw;
                animation: fall 3s linear forwards;
                animation-delay: ${Math.random() * 1}s;
            `;
            container.appendChild(confetti);
        }
        
        // Add CSS for confetti animation
        if (!document.getElementById('confetti-style')) {
            const style = document.createElement('style');
            style.id = 'confetti-style';
            style.textContent = `
                @keyframes fall {
                    0% {
                        transform: translateY(-100vh) rotate(0deg);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(100vh) rotate(720deg);
                        opacity: 0;
                    }
                }
                @keyframes celebrationPop {
                    0% {
                        transform: translate(-50%, -50%) scale(0);
                        opacity: 0;
                    }
                    20% {
                        transform: translate(-50%, -50%) scale(1.1);
                        opacity: 1;
                    }
                    80% {
                        transform: translate(-50%, -50%) scale(1);
                        opacity: 1;
                    }
                    100% {
                        transform: translate(-50%, -50%) scale(0.8);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        // Create celebration message
        const message = document.createElement('div');
        message.className = 'celebration-message';
        message.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: celebrationPop 3s ease forwards;
            pointer-events: auto;
            max-width: 400px;
            z-index: 10000;
        `;
        message.innerHTML = `
            <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🎉</span>
            <h3>Hooray! Challenge Completed!</h3>
            <p>${title?.trim() ? title : "You're making great progress!"}</p>
        `;
        container.appendChild(message);
        
        // Clean up after animation
        setTimeout(() => {
            container.remove();
        }, 3000);
    }

    // Update challenge categories display
    function updateChallengeCategories() {
        const challenges = document.querySelectorAll('.challenge-card');
        const activeCategory = document.querySelector('.category-btn.active');
        const currentCategory = activeCategory ? activeCategory.getAttribute('data-category') : 'all';
        
        challenges.forEach(challenge => {
            if (currentCategory === 'all' || challenge.classList.contains(currentCategory)) {
                challenge.style.display = 'block';
            } else {
                challenge.style.display = 'none';
            }
        });
    }

    // Handle challenge completion
    function handleChallengeCompletion(card, title, checkbox) {
        if (!checkbox.checked) return;

        const progressBar = card.querySelector('.progress-bar');
        const progressText = card.querySelector('.progress-label span:last-child');

        // Update progress
        progressBar.style.width = '100%';
        const [_, total] = progressText.textContent.split('/');
        progressText.textContent = `${total}/${total}`;

        // Show celebration
        createCelebration(title);

        // Add completion banner
        if (!card.querySelector('.challenge-completed-banner')) {
            const banner = document.createElement('div');
            banner.className = 'challenge-completed-banner';
            banner.style.cssText = `
                background: linear-gradient(135deg, #4CAF50, #45a049);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1rem;
                font-weight: 500;
                font-size: 0.9rem;
            `;
            banner.innerHTML = '<i class="fas fa-check-circle" style="font-size: 1.2rem;"></i><span>Completed!</span>';
            card.insertBefore(banner, card.querySelector('.checkbox-container'));
        }

        // Update card styling
        markChallengeAsCompleted(card);
        
        // Update categories and switch to completed view
        setTimeout(() => {
            updateChallengeCategories();
            switchToCompletedCategory();
        }, 1000);
    }

    // Mark challenge as completed
    function markChallengeAsCompleted(card) {
        // Remove category classes
        card.classList.remove('daily', 'weekly', 'monthly');
        card.classList.add('completed');

        // Update type label
        const typeSpan = card.querySelector('.challenge-type');
        if (typeSpan) {
            typeSpan.className = 'challenge-type completed';
            typeSpan.textContent = 'Completed';
        }

        // Update checkbox
        const checkboxContainer = card.querySelector('.checkbox-container');
        const today = new Date();
        const dateString = today.toLocaleDateString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric' 
        });

        checkboxContainer.innerHTML = `
            <input type="checkbox" checked disabled>
            <span class="checkmark"></span>
            Completed on ${dateString}
        `;
    }

    // Switch to completed category
    function switchToCompletedCategory() {
        const completedCategoryBtn = document.querySelector('.category-btn[data-category="completed"]');
        if (completedCategoryBtn) {
            // Remove active class from all buttons
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
            // Add active class to completed button
            completedCategoryBtn.classList.add('active');
            // Update display
            updateChallengeCategories();
        }
    }

    // Initialize category filters
    function initializeCategoryFilters() {
        const categoryButtons = document.querySelectorAll('.category-btn');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Update display
                updateChallengeCategories();
            });
        });
    }

    // Initialize challenge completion
    function initializeChallengeCompletion() {
        const checkboxes = document.querySelectorAll('.challenge-card input[type="checkbox"]:not([disabled])');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    const card = this.closest('.challenge-card');
                    const title = card.querySelector('.challenge-title').textContent;
                    handleChallengeCompletion(card, title, this);
                }
            });
        });
    }
    </script>
</body>
</html>