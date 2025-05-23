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
    <title>QuitZone - Challenges</title>
    <link rel="stylesheet" href="grad.css">
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
            
            <!-- Navigation Links for Desktop -->
            <nav class="nav-desktop">
                <ul>
                    <li><a href="home.html" class="nav-link">Home</a></li>
                    <li><a href="awareness.html" class="nav-link">Awareness</a></li>
                    <li><a href="progress.html" class="nav-link">Progress</a></li>
                    <li><a href="challenges.php" class="nav-link active">Challenges</a></li>
                    <li><a href="savings.php" class="nav-link">Savings</a></li>
                    <li><a href="success_stories.html" class="nav-link">Success Stories</a></li>
                    <li><a href="chatbot.html" class="nav-link">Chatbot</a></li>
                    <li><a href="login.php" class="login-btn">Login</a></li>
            
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
                    <p class="challenge-description">Write about your quit journey for at least 5 minutes every day this month.</p>
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

                <!-- Completed Challenge 1 -->
               
                <div class="challenge-card monthly" data-aos="fade-up" data-aos-delay="750">
                    <div class="challenge-header">
                        <span class="challenge-type monthly">Monthly</span>
                        <span class="challenge-points">+250 pts</span>
                    </div>
                    <h3 class="challenge-title">Trigger Identification</h3>
                    <p class="challenge-description">Identify and write down 5 triggers that make you want to smoke.</p>
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

            </div>

            <!-- Create Your Own Challenge -->
<div class="create-challenge-section">
    <h2 class="subsection-title">Create Your Own Challenge</h2>
    <p class="subsection-description">Design a personal challenge that will help you stay smoke-free</p>
    <div class="create-challenge-form">
        <div class="form-group">
            <label for="challenge-title">Challenge Title</label>
            <input type="text" id="challenge-title" placeholder="E.g., No smoking during work breaks">
        </div>
        <div class="form-group">
            <label for="challenge-description">Description</label>
            <textarea id="challenge-description" placeholder="Describe your challenge and why it will help"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group half">
                <label for="challenge-type">Type</label>
                <select id="challenge-type">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div class="form-group half">
                <label for="challenge-duration">Duration (days)</label>
                <input type="number" id="challenge-duration" value="1" min="1">
            </div>
        </div>
        <button class="create-challenge-btn">Create Challenge</button>
    </div>
</div>

        </div>
    </section>

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
  
      // Create celebration effect
      function createCelebration(title) {
          // Create container for confetti if it doesn't exist
          let container = document.querySelector('.celebration-container');
          if (!container) {
              container = document.createElement('div');
              container.className = 'celebration-container';
              document.body.appendChild(container);
          }
          
          // Create confetti pieces
          const colors = ['#FFD700', '#FF6347', '#00CED1', '#9370DB', '#32CD32', '#FF69B4'];
          const confettiCount = 150;
          
          for (let i = 0; i < confettiCount; i++) {
              const confetti = document.createElement('div');
              confetti.className = 'confetti';
              confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
              confetti.style.left = Math.random() * 100 + 'vw';
              confetti.style.animationDelay = Math.random() * 1 + 's';
              confetti.style.width = Math.random() * 10 + 5 + 'px';
              confetti.style.height = Math.random() * 10 + 5 + 'px';
              container.appendChild(confetti);
          }
          
          // Create celebration message
          const message = document.createElement('div');
          message.className = 'celebration-message';
          message.innerHTML = `
              <span class="celebration-emoji">🎉</span>
              <h3>Hooray! Challenge Completed!</h3>
          <p>${title?.trim() ? title : "You're making great progress!"}</p>`;

          container.appendChild(message);
          
          // Clean up after animation
          setTimeout(() => {
              container.remove();
          }, 3000);
      }
  
      // Update challenge categories list
      function updateChallengeCategories() {
          // Get all challenges
          const challenges = document.querySelectorAll('.challenge-card');
          
          // Get current active category
          const activeCategory = document.querySelector('.category-btn.active');
          const currentCategory = activeCategory ? activeCategory.getAttribute('data-category') : 'all';
          
          // Show/hide challenges based on active category
          challenges.forEach(challenge => {
              if (currentCategory === 'all' || challenge.classList.contains(currentCategory)) {
                  challenge.style.display = 'block';
              } else {
                  challenge.style.display = 'none';
              }
          });
      }
  
      // Challenge filtering functionality
      document.addEventListener('DOMContentLoaded', function() {
          const categoryButtons = document.querySelectorAll('.category-btn');
          const challenges = document.querySelectorAll('.challenge-card');
          
          categoryButtons.forEach(button => {
              button.addEventListener('click', function() {
                  // Remove active class from all buttons
                  categoryButtons.forEach(btn => btn.classList.remove('active'));
                  
                  // Add active class to clicked button
                  this.classList.add('active');
                  
                  const category = this.getAttribute('data-category');
                  
                  // Show/hide challenges based on category
                  challenges.forEach(challenge => {
                      if (category === 'all' || challenge.classList.contains(category)) {
                          challenge.style.display = 'block';
                      } else {
                          challenge.style.display = 'none';
                      }
                  });
              });
          });
  
          // Handle challenge completion
          const checkboxes = document.querySelectorAll('.challenge-card input[type="checkbox"]:not([disabled])');
          
          checkboxes.forEach(checkbox => {
              checkbox.addEventListener('change', function() {
                  const card = this.closest('.challenge-card');
                  const title = card.querySelector('.challenge-title').textContent;
                  
                  if (this.checked) {
                      // Update progress visually
                      const progressBar = card.querySelector('.progress-bar');
                      const progressText = card.querySelector('.progress-label span:last-child');
                      
                      if (progressBar && progressText) {
                          progressBar.style.width = '100%';
                          
                          const [current, total] = progressText.textContent.split('/');
                          progressText.textContent = `${total}/${total}`;
                      }
                      
                      // Create celebration effect
                      createCelebration(title);
                      
                      // Add completed banner if not already there
                      if (!card.querySelector('.challenge-completed-banner')) {
                          const banner = document.createElement('div');
                          banner.className = 'challenge-completed-banner';
                          banner.innerHTML = '<i class="fas fa-check-circle"></i><span>Completed!</span>';
                          
                          // Insert before the checkbox
                          card.insertBefore(banner, card.querySelector('.checkbox-container'));
                      }
                      
                      // Move the card to completed section
                      // 1. Remove existing category classes
                      const originalClass = card.classList.contains('daily') ? 'daily' : 
                                          card.classList.contains('weekly') ? 'weekly' : 
                                          card.classList.contains('monthly') ? 'monthly' : '';
                      
                      card.classList.remove('daily', 'weekly', 'monthly');
                      
                      // 2. Add completed class
                      card.classList.add('completed');
                      
                      // 3. Change the challenge type label
                      const typeSpan = card.querySelector('.challenge-type');
                      if (typeSpan) {
                          typeSpan.className = 'challenge-type completed';
                          typeSpan.textContent = 'Completed';
                      }
                      
                      // 4. Update checkbox label
                      const checkboxContainer = card.querySelector('.checkbox-container');
                      if (checkboxContainer) {
                          const today = new Date();
                          const dateString = today.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                          
                          checkboxContainer.innerHTML = `
                              <input type="checkbox" checked disabled>
                              <span class="checkmark"></span>
                              Completed on ${dateString}
                          `;
                      }
                      
                      // 5. Update the currently selected category view
                      updateChallengeCategories();
                      
                      // 6. Automatically switch to completed category to show the user their completed challenge
                      if (originalClass !== 'completed') {
                          const completedCategoryBtn = document.querySelector('.category-btn[data-category="completed"]');
                          if (completedCategoryBtn) {
                              completedCategoryBtn.click();
                          }
                      }
                  } else {
                      // This part won't be reached for completed challenges since their checkboxes are disabled
                      // But keeping it for custom challenges that haven't been permanently marked as completed
                      
                      // Remove completed banner if exists
                      const banner = card.querySelector('.challenge-completed-banner');
                      if (banner) {
                          banner.remove();
                      }
                      
                      // Update progress bar back
                      const progressBar = card.querySelector('.progress-bar');
                      const progressText = card.querySelector('.progress-label span:last-child');
                      
                      if (progressBar && progressText) {
                          const [_, total] = progressText.textContent.split('/');
                          progressBar.style.width = '0%';
                          progressText.textContent = `0/${total}`;
                      }
                  }
              });
          });
  
          // Create custom challenge
          const createChallengeBtn = document.querySelector('.create-challenge-btn');
          
          if (createChallengeBtn) {
              createChallengeBtn.addEventListener('click', function() {
                  const title = document.getElementById('challenge-title').value.trim();
                  const description = document.getElementById('challenge-description').value.trim();
                  const type = document.getElementById('challenge-type').value;
                  const duration = document.getElementById('challenge-duration').value;
                  
                  
                  if (title && description) {

                   
                      // Create new challenge card
                      const newChallenge = document.createElement('div');
                      newChallenge.className = `challenge-card ${type}`;
                      newChallenge.innerHTML = `
                          <div class="challenge-header">
                              <span class="challenge-type ${type}">${type.charAt(0).toUpperCase() + type.slice(1)}</span>
                              <span class="challenge-points">+${type === 'daily' ? 15 : type === 'weekly' ? 50 : 200} pts</span>
                          </div>
                          <h3 class="challenge-title">${title}</h3>
                          <p class="challenge-description">${description}</p>
                          <div class="challenge-progress">
                              <div class="progress-label">
                                  <span>Progress</span>
                                  <span>0/${duration}</span>
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
                      `;
                      
                      // Add to challenges container
                      const challengesContainer = document.getElementById('challenges-container');
                      challengesContainer.appendChild(newChallenge);
                      
                      // Add event listener to new checkbox
                      const newCheckbox = newChallenge.querySelector('input[type="checkbox"]');
                      newCheckbox.addEventListener('change', function() {
                          const title = newChallenge.querySelector('.challenge-title').textContent;
                          
                          if (this.checked) {
                              // Update progress
                              const progressBar = newChallenge.querySelector('.progress-bar');
                              const progressText = newChallenge.querySelector('.progress-label span:last-child');
                              
                              if (progressBar && progressText) {
                                  progressBar.style.width = '100%';
                                  
                                  const [_, total] = progressText.textContent.split('/');
                                  progressText.textContent = `${total}/${total}`;
                              }
                              
                              // Create celebration effect
                              createCelebration(title);
                              
                              // Add completed banner
                              const banner = document.createElement('div');
                              banner.className = 'challenge-completed-banner';
                              banner.innerHTML = '<i class="fas fa-check-circle"></i><span>Completed!</span>';
                              
                              // Insert before the checkbox
                              newChallenge.insertBefore(banner, newChallenge.querySelector('.checkbox-container'));
                              
                              // Move to completed category
                              // 1. Save original class
                              const originalClass = newChallenge.classList.contains('daily') ? 'daily' : 
                                                  newChallenge.classList.contains('weekly') ? 'weekly' : 
                                                  newChallenge.classList.contains('monthly') ? 'monthly' : '';
                              
                              // 2. Remove existing category classes
                              newChallenge.classList.remove('daily', 'weekly', 'monthly');
                              
                              // 3. Add completed class
                              newChallenge.classList.add('completed');
                              
                              // 4. Change the challenge type label
                              const typeSpan = newChallenge.querySelector('.challenge-type');
                              if (typeSpan) {
                                  typeSpan.className = 'challenge-type completed';
                                  typeSpan.textContent = 'Completed';
                              }
                              
                              // 5. Update checkbox label
                              const checkboxContainer = newChallenge.querySelector('.checkbox-container');
                              if (checkboxContainer) {
                                  const today = new Date();
                                  const dateString = today.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                                  
                                  checkboxContainer.innerHTML = `
                                      <input type="checkbox" checked disabled>
                                      <span class="checkmark"></span>
                                      Completed on ${dateString}
                                  `;
                              }
                              
                              // 6. Update the view
                              updateChallengeCategories();
                              
                              // 7. Switch to completed view
                              const completedCategoryBtn = document.querySelector('.category-btn[data-category="completed"]');
                              if (completedCategoryBtn) {
                                  completedCategoryBtn.click();
                              }
                          } else {
                              // Remove completed banner
                              const banner = newChallenge.querySelector('.challenge-completed-banner');
                              if (banner) {
                                  banner.remove();
                              }
                              
                              // Update progress bar back
                              const progressBar = newChallenge.querySelector('.progress-bar');
                              const progressText = newChallenge.querySelector('.progress-label span:last-child');
                              
                              if (progressBar && progressText) {
                                  const [_, total] = progressText.textContent.split('/');
                                  progressBar.style.width = '0%';
                                  progressText.textContent = `0/${total}`;
                              }
                          }
                      });
                      
                      // Clear form
                      document.getElementById('challenge-title').value = '';
                      document.getElementById('challenge-description').value = '';
                      document.getElementById('challenge-duration').value = '1';
                      
                      // Update categories to show the new challenge
                      updateChallengeCategories();
                      
                      // Scroll to new challenge
                      newChallenge.scrollIntoView({ behavior: 'smooth', block: 'center' });
                  }
              });
          }
      });
    
  </script>
  <script src="common.js"></script>
</body>
</html>