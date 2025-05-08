// js/names.js

document.addEventListener("DOMContentLoaded", function () {
    const actorNames = [
        "Fred Astaire",
        "Lauren Bacall",
        "John Belushi",
        "Ingmar Bergman",
        "Marlon Brando",
        "Richard Burton",
        "Georges Delerue",
        "Henry Fonda",
        "John Gielgud",
        "Jerry Goldsmith",
        "Alec Guinness",
        "Katharine Hepburn",
        "Charlton Heston",
        "William Holden",
        "James Horner",
        "Stanley Kubrick",
        "Akira Kurosawa",
        "Burt Lancaster",
        "Bruce Lee",
        "Sophia Loren",
        "Marcello Mastroianni",
        "Paul Newman"
    ];

    const searchInput = document.getElementById("searchInput");

    if (!searchInput) return;

    const suggestionBox = document.createElement("ul");
    suggestionBox.classList.add("autocomplete-suggestions");
    suggestionBox.style.position = "absolute";
    suggestionBox.style.zIndex = "1000";
    suggestionBox.style.backgroundColor = "#fff";
    suggestionBox.style.border = "1px solid #ccc";
    suggestionBox.style.listStyle = "none";
    suggestionBox.style.padding = "0";
    suggestionBox.style.margin = "0";
    suggestionBox.style.width = searchInput.offsetWidth + "px";
    suggestionBox.style.maxHeight = "200px";
    suggestionBox.style.overflowY = "auto";
    suggestionBox.style.display = "none";

    searchInput.parentNode.appendChild(suggestionBox);

    searchInput.addEventListener("input", function () {
        const query = this.value.trim().toLowerCase();
        suggestionBox.innerHTML = "";

        if (query === "") {
            suggestionBox.style.display = "none";
            return;
        }

        const filteredNames = actorNames.filter(name =>
            name.toLowerCase().startsWith(query)
        );

        if (filteredNames.length === 0) {
            suggestionBox.style.display = "none";
            return;
        }

        filteredNames.forEach(name => {
            const li = document.createElement("li");
            li.textContent = name;
            li.style.padding = "10px";
            li.style.cursor = "pointer";

            li.addEventListener("click", function () {
                searchInput.value = name;
                suggestionBox.innerHTML = "";
                suggestionBox.style.display = "none";
            });

            li.addEventListener("mouseover", function () {
                li.style.backgroundColor = "#f0f0f0";
            });

            li.addEventListener("mouseout", function () {
                li.style.backgroundColor = "#fff";
            });

            suggestionBox.appendChild(li);
        });

        suggestionBox.style.display = "block";
    });

    document.addEventListener("click", function (e) {
        if (e.target !== searchInput && e.target.parentNode !== suggestionBox) {
            suggestionBox.innerHTML = "";
            suggestionBox.style.display = "none";
        }
    });
});
