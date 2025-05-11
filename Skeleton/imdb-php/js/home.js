/* Home JavaScript */

/* Back to Top when scrolled down */
document.addEventListener("DOMContentLoaded", () => {
    const backToTopBtn = document.getElementById("backToTopBtn");

    window.addEventListener("scroll", () => {
        const scrolledFromTop = window.scrollY;
        const nearBottom = window.innerHeight + scrolledFromTop >= document.body.scrollHeight - 100;

        // Show button only near bottom of the page
        if (nearBottom) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });

    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
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




