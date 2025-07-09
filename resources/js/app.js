console.log("✅ JavaScript is active");

document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const toggleBtn = document.getElementById('toggleDark');
    const icon = document.getElementById('darkIcon');

    // Set default theme from localStorage
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        html.classList.add('dark');
        icon.textContent = '☀️';
    } else {
        html.classList.remove('dark');
        icon.textContent = '🌙';
    }

    toggleBtn.addEventListener('click', function () {
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        icon.textContent = isDark ? '☀️' : '🌙';
        console.log("🔄 Theme toggled:", isDark ? "dark" : "light");
    });
});
