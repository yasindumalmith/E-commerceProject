document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.navbar-toggle');
    const menu = document.querySelector('.navbar-menu');
    if (toggle && menu) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('active');
        });

        // Optional: Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (menu.classList.contains('active') && !menu.contains(e.target) && e.target !== toggle) {
                menu.classList.remove('active');
            }
        });

        // Optional: Close menu when clicking a link
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                menu.classList.remove('active');
            });
        });
    }
});