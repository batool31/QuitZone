<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'data.Base.php';

$userId = $_SESSION['user_id'];

// استعلام لإحضار نقاط المستخدم
$sql = "SELECT points FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $points = intval($row['points']);
} else {
    $points = 0; // إذا ما وجد نقاط في قاعدة البيانات
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QuitZone - Savings</title>
  <link rel="stylesheet" href="grad.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  
  <!-- Header -->
  <header class="navbar">
    <div class="container">
      <a href="home.html" class="logo">
        <span>QuitZone</span>
        <span class="emoji">🚭</span>
      </a>
      
      <!-- Navigation Links for Desktop -->
      <nav class="nav-desktop">
        <ul>
          <li><a href="home.html" class="nav-link">Home</a></li>
          <li><a href="awareness.html" class="nav-link">Awareness</a></li>
          <li><a href="progress.html" class="nav-link">Progress</a></li>
          <li><a href="challenges.php" class="nav-link">Challenges</a></li>
          <li><a href="savings.php" class="nav-link active">Savings</a></li>
          <li><a href="success_stories.html" class="nav-link">Success Stories</a></li>
          <li><a href="chatbot.html" class="nav-link">Chatbot</a></li>
          <li><a href="login.php" class="login-btn">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container savings-container">
    
    <h1 class="savings-title" data-aos="fade-up">Your Smoke-Free Bank</h1>
    <p class="savings-subtitle" data-aos="fade-up" data-aos-delay="200">
      Every day you stay smoke-free, your wallet gets fatter and your future gets brighter.
    </p>
    <div class="calculator-section" data-aos="fade-up" data-aos-delay="500">
      <div class="calculator-header">
        <h2><i class="fas fa-calculator"></i> Calculate Your Savings</h2>
        <p>See how much you're saving by not smoking!</p>
      </div>
      
      <div class="calculator-form">
        <div class="form-group">
          <label for="daily-expense">
            <i class="fas fa-coins"></i> 
            How much did you spend per day on smoking?
          </label>
          <div class="input-with-icon">
            <span class="currency-symbol">$</span>
            <input type="number" id="daily-expense" placeholder="Amount per day" min="0" max="3" step="0.01">
          </div>
        </div>
        
        <div class="form-group">
          <label for="daily-cigarettes">
            <i class="fas fa-smoking"></i> 
            How many cigarettes did you smoke per day?
          </label>
          <input type="number" id="daily-cigarettes" placeholder="Number of cigarettes" min="0" max="60">
        </div>
        
        <div class="form-group">
          <label for="days-quit">
            <i class="fas fa-hourglass-half"></i> 
            How many days have you been smoke-free?
          </label>
          <input type="number" id="days-quit" placeholder="Number of days" min="0">
        </div>
        
        <button id="calculate-savings" class="calculate-btn">
          <i class="fas fa-calculator"></i> Calculate Savings
        </button>
      </div>
    </div>
    <div class="savings-dashboard" data-aos="fade-up" data-aos-delay="300">
      <div class="savings-summary">
        <div class="savings-card">
          <div class="savings-icon">
            <i class="fas fa-piggy-bank"></i>
          </div>
          <div class="savings-amount">
            <span class="amount-label">Total Saved</span>
            <span class="amount-value" id="total-saved">$0.00</span>
          </div>
        </div>
        
        <div class="savings-card">
          <div class="savings-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <div class="savings-amount">
            <span class="amount-label">Smoke-Free Days</span>
            <span class="amount-value" id="smoke-free-days">0</span>
          </div>
        </div>
        
        <div class="savings-card">
          <div class="savings-icon">
            <i class="fas fa-ban"></i>
          </div>
          <div class="savings-amount">
            <span class="amount-label">Cigarettes Avoided</span>
            <span class="amount-value" id="cigarettes-avoided">0</span>
          </div>
        </div>
      </div>
    </div>

    
    
    <div class="savings-chart-container" data-aos="fade-up" data-aos-delay="400">
      <h2>Your Savings Growth</h2>
      <div class="savings-chart">
        <canvas id="savingsChart"></canvas>
      </div>
    </div>
    
    <div class="savings-projection" data-aos="fade-up" data-aos-delay="600">
      <h2>Future Savings Projection</h2>
      <div class="projection-grid">
        <div class="projection-card">
          <div class="projection-period">1 Month</div>
          <div class="projection-amount" id="month-projection">$0</div>
        </div>
        
        <div class="projection-card">
          <div class="projection-period">6 Months</div>
          <div class="projection-amount" id="six-month-projection">$0</div>
        </div>
        
        <div class="projection-card">
          <div class="projection-period">1 Year</div>
          <div class="projection-amount" id="year-projection">$0</div>
        </div>
        
        <div class="projection-card">
          <div class="projection-period">5 Years</div>
          <div class="projection-amount" id="five-year-projection">$0</div>
        </div>
      </div>
    </div>

    
      <div class="rewards-section" data-aos="fade-up" data-aos-delay="700">
        <div class="rewards-header">
          <h2><i class="fas fa-gift"></i> Rewards Vault</h2>
          <p>Trade in your smoke-free points for amazing rewards!</p>
          <div class="points-display">
            <i class="fas fa-star"></i>
            <span id="points">0</span> Points Collected
          </div>
        </div>
        
        <div class="rewards-grid">
          <!-- Reward Card 1 -->
          <div class="reward-card">
            <div class="reward-points">500 Points</div>
            <i class="reward-icon fas fa-coffee"></i>
            <h3>Coffee Shop Gift Card</h3>
            <p>Treat yourself to your favorite coffee after staying smoke-free.</p>
            <button class="redeem-btn" data-id="1" data-points="500" data-reward="Coffee Shop Gift Card">Redeem</button>

          </div>
    
          <!-- Reward Card 2 -->
          <div class="reward-card">
            <div class="reward-points">750 Points</div>
            <i class="reward-icon fas fa-headphones"></i>
            <h3>Music Subscription</h3>
            <p>One month of premium music streaming to celebrate your progress.</p>
            <button class="redeem-btn" data-id="2" data-points="750" data-reward="Music Subscription">Redeem</button>

          </div>
          
          <!-- Reward Card 3 (Premium/Locked) -->
          <div class="reward-card locked">
            <div class="reward-points">1000 Points</div>
            <i class="reward-icon fas fa-crown"></i>
            <h3>Premium Membership</h3>
            <p>Unlock exclusive features and content to support your journey.</p>
           <button class="redeem-btn disabled" data-id="3" data-points="1000" data-reward="Free Mug">Locked</button>

            <div class="points-needed">Need 1000 more points</div>
          </div>
        </div>
      </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <a href="home.html">
            <span>QuitZone</span>
            <span class="emoji">🚭</span>
          </a>
          <p>Your partner in the journey to a smoke-free life.</p>
        </div>
        
        <div class="footer-links">
          <div class="footer-column">
            <h3>Pages</h3>
            <ul>
              <li><a href="home.html">Home</a></li>
              <li><a href="progress.html">Progress</a></li>
              <li><a href="challenges.php">Challenges</a></li>
              <li><a href="savings.php">Savings</a></li>
              <li><a href="success_stories.html">Success Stories</a></li>
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

  <!-- AOS Animation Library -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
  // Initialize AOS Animation
 AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: true
});

document.addEventListener('DOMContentLoaded', function () {
  const dailyExpenseInput = document.getElementById('daily-expense');
  const dailyCigarettesInput = document.getElementById('daily-cigarettes');
  const daysQuitInput = document.getElementById('days-quit');
  const calculateBtn = document.getElementById('calculate-savings');
  const pointsElement = document.getElementById('points');

  dailyExpenseInput.addEventListener('input', function () {
    if (this.value > 12) this.value = 12;
  });

  dailyCigarettesInput.addEventListener('input', function () {
    if (this.value > 60) this.value = 60;
  });

  const ctx = document.getElementById('savingsChart').getContext('2d');
  const savingsChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Day 1', 'Week 1', 'Month 1', 'Month 3', 'Month 6', 'Year 1'],
      datasets: [{
        label: 'Savings ($)',
        data: [0, 0, 0, 0, 0, 0],
        borderColor: '#37474F',
        backgroundColor: 'rgba(55, 71, 79, 0.1)',
        tension: 0.3,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top' },
        tooltip: {
          mode: 'index',
          intersect: false,
          callbacks: {
            label: context => `Savings: $${context.raw.toFixed(2)}`
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Savings ($)' }
        },
        x: {
          title: { display: true, text: 'Time Period' }
        }
      }
    }
  });

function calculateSavings() {
  const dailyExpense = parseFloat(dailyExpenseInput.value) || 0;
  const dailyCigarettes = parseInt(dailyCigarettesInput.value) || 0;
  const daysQuit = parseInt(daysQuitInput.value) || 0;

  if (dailyExpense === 0 || dailyCigarettes === 0 || daysQuit === 0) {
    alert("Please fill in all fields with values greater than zero.");
    return;
  }

  const totalSaved = dailyExpense * daysQuit;
  const newPoints = Math.floor(totalSaved);

  document.getElementById('total-saved').textContent = totalSaved.toFixed(2);
  document.getElementById('smoke-free-days').textContent = daysQuit;
  document.getElementById('cigarettes-avoided').textContent = dailyCigarettes * daysQuit;
  document.getElementById('month-projection').textContent = '$' + (dailyExpense * 30).toFixed(2);
  document.getElementById('six-month-projection').textContent = '$' + (dailyExpense * 180).toFixed(2);
  document.getElementById('year-projection').textContent = '$' + (dailyExpense * 365).toFixed(2);
  document.getElementById('five-year-projection').textContent = '$' + (dailyExpense * 1825).toFixed(2);
  pointsElement.textContent = newPoints;

  // 👇👇 إرسال النقاط إلى الخادم لتخزينها
  fetch('update_points.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `points=${newPoints}`
  });

  savingsChart.data.datasets[0].data = [
    dailyExpense,
    dailyExpense * 7,
    dailyExpense * 30,
    dailyExpense * 90,
    dailyExpense * 180,
    dailyExpense * 365
  ];
  savingsChart.update();
  updateRedeemButtons(newPoints);
}

function updateRedeemButtons(currentPoints) {
  document.querySelectorAll('.redeem-btn').forEach(btn => {
    const requiredPoints = parseInt(btn.getAttribute('data-points'));
    if (currentPoints >= requiredPoints) {
      btn.disabled = false;
      btn.classList.remove('disabled');
    } else {
      btn.disabled = true;
      btn.classList.add('disabled');
    }
  });
}

function handleRedemption(button) {
  const rewardId = button.getAttribute('data-id');
  const rewardName = button.getAttribute('data-reward');
  const pointsCost = parseInt(button.getAttribute('data-points'));
  const currentPoints = parseInt(pointsElement.textContent);

  if (currentPoints < pointsCost) return;

  fetch('redeem_reward.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `reward_id=${rewardId}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(`You have successfully redeemed: ${rewardName}`);
      pointsElement.textContent = data.new_points;
      updateRedeemButtons(data.new_points);
    } else {
      alert(data.message || 'Redemption failed.');
    }
  })
  .catch((err) => {
    console.error(err);
    alert("Redemption failed. Please try again later.");
  });
}

calculateBtn.addEventListener('click', calculateSavings);

document.querySelectorAll('.redeem-btn').forEach(btn => {
  btn.addEventListener('click', function () {
    handleRedemption(this);
  });
});

});
</script>
  <script src="common.js"></script>
</body>
</html>