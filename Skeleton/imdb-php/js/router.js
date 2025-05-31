document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.nav-link');
    const mainContent = document.getElementById('main-content');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('href');

            // Load the page dynamically
            fetch(page)
                .then(response => response.text())
                .then(html => {
                    mainContent.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    mainContent.innerHTML = '<p>Page could not be loaded.</p>';
                });
        });
    });
});
