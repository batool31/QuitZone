document.addEventListener("DOMContentLoaded", () => {
    const quitDate = new Date("2025-01-01T00:00:00"); // Replace with user's actual quit date

    function updateSmokeFreeStats() {
        const now = new Date();
        const timeDiff = now - quitDate;

        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));4
        const hours = Math.floor((timeDiff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((timeDiff / (1000 * 60)) % 60);
        const seconds = Math.floor((timeDiff / 1000) % 60);

        const statsElement = document.getElementById("days-free");
        const moneyElement = document.getElementById("money-saved");
        const healthElement = document.getElementById("health-benefit");

        if (statsElement) statsElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        if (moneyElement) moneyElement.textContent = (days * 10).toFixed(2);

        if (healthElement) {
            let health = "Getting Better!";
            if (days >= 1) health = "Heart rate normalized 💓";
            if (days >= 3) health = "Nicotine-free 💪";
            if (days >= 7) health = "Taste buds improved 👅";
            if (days >= 30) health = "Lung function improved 🫁";
            healthElement.textContent = health;
        }
    }

    updateSmokeFreeStats();
    setInterval(updateSmokeFreeStats, 1000);
});

let activeTimers = {};

function toggleDetails(id) {
    const details = document.getElementById(id);
    if (details) {
        details.style.display = (details.style.display === 'block') ? 'none' : 'block';
    }
}

function startChallenge(challengeId, duration) {
    if (activeTimers[challengeId]) {
        alert("The challenge timer is already running!");
        return;
    }

    let timer = duration * 60;
    const display = document.getElementById(`${challengeId}-timer`);
    const activityList = document.getElementById(`${challengeId}-activities`);
    activityList.innerHTML = "";

    activeTimers[challengeId] = setInterval(() => {
        let minutes = Math.floor(timer / 60);
        let seconds = timer % 60;

        if (display) display.textContent = `${minutes}m ${seconds}s`;

        if (--timer < 0) {
            clearInterval(activeTimers[challengeId]);
            delete activeTimers[challengeId];
            alert("🎉 Congratulations! You completed the challenge!");
        }
    }, 1000);
}

function logActivity(activity, challengeId) {
    const log = document.getElementById("activity-log");
    const entry = document.createElement("li");
    entry.textContent = `${activity} - Done! ✅`;
    if (log) log.appendChild(entry);

    const activityList = document.getElementById(`${challengeId}-activities`);
    const activityEntry = document.createElement("li");
    activityEntry.textContent = activity;
    if (activityList) activityList.appendChild(activityEntry);
}

function chooseExercise(challengeId) {
    const exercise = prompt("Enter an exercise (e.g., Jumping Jacks, Push-ups, Squats):");
    if (exercise) {
        logActivity(`Did ${exercise}`, challengeId);
        giveExerciseMotivation(exercise);
    }
}

function giveExerciseMotivation(exercise) {
    const messages = {
        'Jumping Jacks': "Great job! Jumping Jacks will help boost your energy!",
        'Stretching': "Awesome! Stretching relaxes your body and mind.",
        'Push-ups': "You're getting stronger with every push-up!",
        'Squats': "Squats are perfect for building leg strength!",
        'Plank': "Holding a plank will improve your core stability!",
        'Burpees': "Burpees will give you a full-body workout!"
    };
    alert(messages[exercise] || `Awesome! Keep going with ${exercise}! 💥`);
}
