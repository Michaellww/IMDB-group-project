<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<?php include_once 'navigation.php'; ?>

<main class="container-fluid bg-light p-4" style="margin-top: 70px;">

    <h2 class="mb-4">🎬 Movie and Series Titles</h2>

    <!-- 🔍 Filter -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="search-input" class="form-control" placeholder="Search by title or type...">
        </div>
    </div>

    <!-- 📋 Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="titles-table">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            <!-- Table rows will be inserted here with JS -->
            </tbody>
        </table>
    </div>

</main>

<?php include_once 'footer.php'; ?>

<!-- JS for loading and filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Example data you provided (shortened version to demonstrate)
        const titles = [
            { title: "Shiva und die Galgenblume", type: "movie" },
            { title: "Let There Be Light", type: "movie" },
            { title: "Nagarik", type: "movie" },
            { title: "Catweazle", type: "tvSeries" },
            { title: "UFO", type: "tvSeries" },
            // Add the rest of your full data here (or load from server later)
        ];

        const tableBody = document.querySelector('#titles-table tbody');
        const searchInput = document.getElementById('search-input');

        // Function to render rows
        function renderTable(data) {
            tableBody.innerHTML = '';
            data.forEach(item => {
                const row = `<tr>
        <td>${item.title}</td>
        <td>${item.type}</td>
      </tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Initial load
        renderTable(titles);

        // Filter logic
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const filtered = titles.filter(item =>
                item.title.toLowerCase().includes(query) ||
                item.type.toLowerCase().includes(query)
            );
            renderTable(filtered);
        });
    });
</script>

<!-- 🔝 Back to Top Button -->
<button id="backToTopBtn" class="btn btn-primary position-fixed" style="top: 20px; left: 50%; transform: translateX(-50%); display: none; z-index: 1050;">
    ↑ Back to Top
</button>



<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="js/home.js"></script>
</body>
</html>