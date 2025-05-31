<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>IMDB 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        /* Autocomplete dropdown style */
        #autocomplete-list {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        }
        .autocomplete-item {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .autocomplete-item:hover {
            background-color: #f8f9fa;
        }
        .autocomplete-item img {
            width: 40px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 3px;
        }
        .autocomplete-text {
            flex-grow: 1;
        }
        .suggestion-title {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
        }
        .suggestion-detail {
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>
<body>

<!-- Login status bubble (hidden by default) -->
<div id="login-bubble" class="bubble-text position-absolute top-0 end-0 mt-2 me-3" style="display: none;">
    🚫 Not Logged In
</div>

<main role="main" class="container bg-light py-4 position-relative" style="max-width: 720px;">
    <?php include_once 'navigation.php' ?>
    <?php include_once 'database.php'; ?>

    <div class="row justify-content-center my-4">
        <img class="img-thumbnail img-banner" src="images/yoda.jpeg" alt="Yoda" />
        <h4 class="text-center mt-3">Yoda: “Looking? Found someone you have, eh?”</h4>
    </div>

    <div class="row align-middle align-items-center py-2 position-relative">
        <div class="offset-2 col-7 align-middle position-relative">
            <input id="searchInput" class="form-control" type="text" name="search" placeholder="Search for a Film, Series, or Person..." autocomplete="off" />
            <div id="autocomplete-list"></div> <!-- Autocomplete list -->
        </div>

        <div class="col-2 d-grid">
            <button id="search-button" type="button" class="btn btn-warning">Search</button>
        </div>
    </div>

    <div class="row mt-4">
        <div id="search-results" class="col-12"></div>
    </div>

    <?php include_once 'cookiepopup.php'; ?>
</main>

<?php include_once 'footer.php'; ?>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
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
</script>
</body>
</html>
