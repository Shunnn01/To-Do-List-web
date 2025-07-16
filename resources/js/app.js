console.log("✅ JavaScript is active");

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleDark');
    const html = document.documentElement;

    // Set awal dari localStorage
    if (localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    toggleBtn?.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });
});