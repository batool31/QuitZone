// Ensure page scrolls to top when refreshed or loaded
window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

// Also force scroll to top when the page loads
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo(0, 0);
});