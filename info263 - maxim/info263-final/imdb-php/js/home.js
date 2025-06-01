let isLoggedIn = false;

fetch('check_login.php')
    .then(res => res.json())
    .then(data => {
        const statusText = document.getElementById('login-status-nav');
        if (data.loggedIn) {
            isLoggedIn = true;
            if (statusText) {
                statusText.innerHTML = '👤 <span class="text-success">Login Success</span>';
            }
            document.getElementById('search-button').disabled = false;
        } else {
            isLoggedIn = false;
            if (statusText) {
                statusText.innerHTML = '👤 <span class="text-muted">Not logged in</span>';
            }
            document.getElementById('search-button').disabled = true;
        }
    })
    .catch(() => {
        isLoggedIn = false;
        const statusText = document.getElementById('login-status-nav');
        if (statusText) {
            statusText.innerHTML = '👤 <span class="text-muted">Not logged in</span>';
        }
        document.getElementById('search-button').disabled = true;
    });


function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

// Get DOM elements
const input = document.getElementById('search-input');
const searchButton = document.getElementById('search-button');
const list = document.getElementById('autocomplete-list');
const resultsContainer = document.getElementById('search-results');

let isLoggedIn = false;

// Check login status from server
fetch('check_login.php')
    .then(res => res.json())
    .then(data => {
        if (data.loggedIn) {
            isLoggedIn = true;
            document.getElementById('login-status').style.display = 'none';
            searchButton.disabled = false;
        } else {
            isLoggedIn = false;
            document.getElementById('login-status').style.display = 'block';
            searchButton.disabled = true;
        }
    })
    .catch(() => {
        isLoggedIn = false;
        document.getElementById('login-status').style.display = 'block';
        searchButton.disabled = true;
    });

// Autocomplete search function
const autoCompleteSearch = debounce(() => {
    if (!isLoggedIn) return;

    const query = input.value.trim();
    if (query === "") {
        list.classList.add("d-none");
        return;
    }

    fetch("search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            list.innerHTML = "";
            if (!data || data.length === 0) {
                list.innerHTML = "<div class='p-2'>No results found.</div>";
                list.classList.remove("d-none");
                return;
            }

            data.forEach(item => {
                const div = document.createElement("div");
                div.className = "autocomplete-item";

                const img = document.createElement("img");
                img.src = "images/movie_not_found.jpeg";
                img.style.width = "40px";
                img.style.height = "60px";
                img.style.objectFit = "cover";
                img.style.marginRight = "10px";
                div.appendChild(img);

                const text = document.createElement("div");
                text.className = "autocomplete-text";
                text.innerHTML = `
                    <div class="suggestion-title">${item.name}</div>
                    <div class="suggestion-detail">${item.type}</div>`;
                div.appendChild(text);

                div.style.display = "flex";
                div.style.alignItems = "center";
                div.style.cursor = "pointer";
                div.style.padding = "5px 10px";

                div.addEventListener("click", () => {
                    input.value = item.name;
                    list.classList.add("d-none");
                    doSearch(item.name);
                });

                list.appendChild(div);
            });
            list.classList.remove("d-none");
        })
        .catch(() => {
            list.innerHTML = "<div class='p-2 text-danger'>Failed to fetch autocomplete results.</div>";
            list.classList.remove("d-none");
        });
}, 300);

// Bind input to trigger autocomplete
input.addEventListener("input", autoCompleteSearch);

// Main search function
function doSearch(query) {
    if (!isLoggedIn) {
        alert("Please log in first.");
        return;
    }

    if (!query) {
        alert("Please enter a keyword.");
        return;
    }

    list.classList.add("d-none");
    resultsContainer.innerHTML = "<p>Loading...</p>";

    fetch("search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            resultsContainer.innerHTML = "";

            if (!data || data.length === 0) {
                resultsContainer.innerHTML = "<p class='text-danger'>No results found.</p>";
                return;
            }

            const filteredMovies = data.filter(item => item.type === 'Title (movie)');

            if (filteredMovies.length === 0) {
                resultsContainer.innerHTML = "<p class='text-danger'>No movies found.</p>";
                return;
            }

            filteredMovies.forEach(movie => {
                const card = document.createElement("div");
                card.className = "card mb-3";

                const row = document.createElement("div");
                row.className = "row g-0";

                const colImg = document.createElement("div");
                colImg.className = "col-md-2";
                const img = document.createElement("img");
                img.src = "images/movie_not_found.jpeg";
                img.className = "img-fluid rounded-start";
                colImg.appendChild(img);

                const colBody = document.createElement("div");
                colBody.className = "col-md-10";
                const cardBody = document.createElement("div");
                cardBody.className = "card-body";
                cardBody.innerHTML = `
                    <h5 class="card-title">${movie.name}</h5>
                    <p class="card-text">${movie.type}</p>`;
                colBody.appendChild(cardBody);

                row.appendChild(colImg);
                row.appendChild(colBody);
                card.appendChild(row);

                resultsContainer.appendChild(card);
            });
        })
        .catch(error => {
            console.error("Search error:", error);
            resultsContainer.innerHTML = "<p class='text-danger'>Search failed. Please try again.</p>";
        });
}

// Bind search button
searchButton.addEventListener("click", () => {
    const query = input.value.trim();
    doSearch(query);
});
function doSearch(query) {
    if (!isLoggedIn) {
        alert("Please log in first.");
        return;
    }

    if (!query.trim()) {
        alert("Please enter a keyword.");
        return;
    }

    // 原来的 fetch 搜索逻辑……
}

// Debounce function
function debounce(fn, delay = 300) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

const input = document.getElementById('searchInput');
const list = document.getElementById('autocomplete-list');
const searchButton = document.getElementById('search-button');
const resultsContainer = document.getElementById('search-results');

let debounceAutocomplete = debounce(() => {
    const query = input.value.trim();
    if (!query) {
        list.style.display = 'none';
        return;
    }
    fetch("search.php?query=" + encodeURIComponent(query))
        .then(res => res.json())
        .then(data => {
            list.innerHTML = "";
            if (!data || data.length === 0) {
                list.innerHTML = `<div class="p-2 text-muted">No results found.</div>`;
                list.style.display = 'block';
                return;
            }
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'autocomplete-item';

                const img = document.createElement('img');
                img.src = 'images/movie_not_found.jpeg'; // Default image if not available
                div.appendChild(img);

                const text = document.createElement('div');
                text.className = 'autocomplete-text';
                text.innerHTML = `
                    <div class="suggestion-title">${item.name}</div>
                    <div class="suggestion-detail">${item.type}</div>
                `;
                div.appendChild(text);

                div.addEventListener('click', () => {
                    input.value = item.name;
                    list.style.display = 'none';
                    performSearch(item.name);
                });

                list.appendChild(div);
            });
            list.style.display = 'block';
        })
        .catch(() => {
            list.innerHTML = `<div class="p-2 text-danger">Failed to fetch autocomplete results.</div>`;
            list.style.display = 'block';
        });
}, 300);

// Handle input changes
input.addEventListener('input', debounceAutocomplete);

// Trigger search
function performSearch(query) {
    if (!query.trim()) {
        alert("Please enter a keyword.");
        return;
    }
    list.style.display = 'none';
    resultsContainer.innerHTML = "<p>Loading...</p>";

    fetch("search.php?query=" + encodeURIComponent(query))
        .then(res => res.json())
        .then(data => {
            resultsContainer.innerHTML = "";
            if (!data || data.length === 0) {
                resultsContainer.innerHTML = `<p class="text-danger">No results found.</p>`;
                return;
            }

            const filteredMovies = data.filter(item => item.type === 'Title (movie)');

            if (filteredMovies.length === 0) {
                resultsContainer.innerHTML = `<p class="text-danger">No movies found.</p>`;
                return;
            }

            filteredMovies.forEach(movie => {
                const card = document.createElement('div');
                card.className = 'card mb-3';

                const row = document.createElement('div');
                row.className = 'row g-0';

                const colImg = document.createElement('div');
                colImg.className = 'col-md-2';

                const img = document.createElement('img');
                img.src = 'images/movie_not_found.jpeg';
                img.className = 'img-fluid rounded-start';
                colImg.appendChild(img);

                const colBody = document.createElement('div');
                colBody.className = 'col-md-10';

                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                cardBody.innerHTML = `
                    <h5 class="card-title">${movie.name}</h5>
                    <p class="card-text">${movie.type}</p>
                `;

                colBody.appendChild(cardBody);
                row.appendChild(colImg);
                row.appendChild(colBody);
                card.appendChild(row);

                resultsContainer.appendChild(card);
            });
        })
        .catch(() => {
            resultsContainer.innerHTML = `<p class="text-danger">Search failed. Please try again later.</p>`;
        });
}

searchButton.addEventListener('click', () => {
    performSearch(input.value);
});

// Enter key support
input.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
        performSearch(input.value);
        list.style.display = 'none';
        e.preventDefault();
    }
});

// Hide autocomplete on outside click
document.addEventListener('click', e => {
    if (!list.contains(e.target) && e.target !== input) {
        list.style.display = 'none';
    }
});

