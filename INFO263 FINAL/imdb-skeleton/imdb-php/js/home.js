/* Home JavaScript
*
* Implement the Search functionality with Ajax.
* */
const input = document.getElementById("searchInput");
const list = document.getElementById("autocomplete-list");

input.addEventListener("input", () => {
    const query = input.value.trim();
    if (query === "") {
        list.classList.add("d-none");
        return;
    }

    fetch("search.php?search=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            list.innerHTML = "";
            if (data.length === 0) {
                list.innerHTML = "<div class='p-2'>No results found.</div>";
                list.classList.remove("d-none");
                return;
            }

            data.forEach(item => {
                const div = document.createElement("div");
                div.className = "autocomplete-item";

                const img = document.createElement("img");
                img.src = item.image || "https://img.icons8.com/?size=100&id=2998&format=png&color=000000";
                div.appendChild(img);

                const text = document.createElement("div");
                text.className = "autocomplete-text";
                if (item.type === 'person') {
                    text.innerHTML = `<div class="suggestion-title">${item.primaryName}</div><div class="suggestion-detail">${item.primaryProfession}</div>`;
                } else {
                    text.innerHTML = `<div class="suggestion-title">${item.primaryTitle}</div><div class="suggestion-detail">${item.genres}</div>`;
                }

                div.appendChild(text);
                div.addEventListener("click", () => {
                    input.value = item.type === 'person' ? item.primaryName : item.primaryTitle;
                    list.classList.add("d-none");
                });

                list.appendChild(div);
            });
            list.classList.remove("d-none");
        });
});

document.addEventListener("click", (e) => {
    if (!list.contains(e.target) && e.target !== input) {
        list.classList.add("d-none");
    }
});

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