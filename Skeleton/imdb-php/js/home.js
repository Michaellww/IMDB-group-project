/* Home JavaScript */
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
