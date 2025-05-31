/* Home JavaScript */

/* Back to Top when scrolled down */
document.addEventListener("DOMContentLoaded", () => {
    const backToTopBtn = document.getElementById("backToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 55) {  // Show button when scrolled down 55px or more
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });

    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});

/*Cookie popup*/
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}

function acceptCookies() {
    setCookie('cookiesAccepted', 'true', 365);
    document.getElementById('cookieConsent').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    if (!getCookie('cookiesAccepted')) {
        document.getElementById('cookieConsent').style.display = 'block';
    }
});

/*Left and right arrow response to moving cards */

function scrollPane(containerId, direction) {
    const container = document.getElementById(containerId);
    const card = container.querySelector('.card');
    const gap = parseInt(getComputedStyle(container).gap) || 16;
    const scrollAmount = (card.offsetWidth + gap) * 3;

    container.parentElement.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}

/*Alphabetical filter*/
document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('sortMovies');
    const container = document.getElementById('movieListContainer');

    sortSelect.addEventListener('change', function () {
    const items = Array.from(container.children);

    items.sort((a, b) => {
    const textA = a.textContent.trim().toLowerCase();
    const textB = b.textContent.trim().toLowerCase();

    return this.value === 'asc'
    ? textA.localeCompare(textB)
    : textB.localeCompare(textA);
});

    // Reinsert sorted items
    items.forEach(item => container.appendChild(item));
});
});




