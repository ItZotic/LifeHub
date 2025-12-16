// Dark Mode Handler
(function() {
    // Check for user's dark mode preference from database
    const darkModeEnabled = document.documentElement.dataset.darkMode === 'true';
    
    // Apply dark mode immediately on page load to prevent flash
    if (darkModeEnabled) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    
    // Also check localStorage for instant toggle feedback
    const storedDarkMode = localStorage.getItem('darkMode');
    if (storedDarkMode === 'enabled') {
        document.documentElement.classList.add('dark');
    } else if (storedDarkMode === 'disabled') {
        document.documentElement.classList.remove('dark');
    }
})();