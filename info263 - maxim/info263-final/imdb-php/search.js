// Debounce function to delay requests
function debounce(fn, delay = 300) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}


const input = document.getElementById('searchInput');
const list = document.getElementById('autocomplete-list');
const searchButton = document.getElementById('search-button');
const resultsContainer = document.getElementById('search-results');


// Autocomplete handler
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
                img.src = item.image || 'images/movie_not_found.jpeg';
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


input.addEventListener('input', debounceAutocomplete);


// Perform the actual search (with results rendering)
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


            data.forEach(item => {
                const card = document.createElement('div');
                card.className = 'card mb-3';


                const row = document.createElement('div');
                row.className = 'row g-0';


                const colImg = document.createElement('div');
                colImg.className = 'col-md-2';


                const img = document.createElement('img');
                img.src = item.image || 'images/movie_not_found.jpeg';
                img.className = 'img-fluid rounded-start';
                colImg.appendChild(img);


                const colBody = document.createElement('div');
                colBody.className = 'col-md-10';


                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                cardBody.innerHTML = `
                   <h5 class="card-title">${item.name}</h5>
                   <p class="card-text">${item.type}</p>
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


// Trigger search by button click
searchButton.addEventListener('click', () => {
    performSearch(input.value);
});


// Trigger search on Enter key
input.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
        performSearch(input.value);
        list.style.display = 'none';
        e.preventDefault();
    }
});


// Hide autocomplete list when clicking outside
document.addEventListener('click', e => {
    if (!list.contains(e.target) && e.target !== input) {
        list.style.display = 'none';
    }
});


