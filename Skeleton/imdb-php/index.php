<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB</title>
    <!-- Favicon for browser tab -->
    <link rel="icon" type="image/png" href="images/favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navigation -->
<?php include_once 'navigation.php'; ?>

<!-- Main Layout -->
<main class="container-fluid px-4 bg-light flex-grow-1" style="margin-top: 70px;">
    <div class="row">

        <!-- 🧱 LEFT COLUMN (Base layout) -->
        <div class="col-lg-7">
            <!-- Sections like Popular Movies, Actors, etc. -->
            <section id="popular-movies" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">🎬 Popular Movies</h4>
                <div class="row" id="movie-results"></div>
            </section>

            <section id="popular-actors" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">🌟 Popular Actors</h4>
                <div class="row" id="actor-results"></div>
            </section>

            <section id="birthday-celebs" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">🎂 Birthdays Today</h4>
                <div class="row" id="birthday-results"></div>
            </section>

            <section id="top-rated" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">⭐ Top Rated</h4>
                <div class="row" id="top-rated-results"></div>
            </section>

            <section id="popular-characters" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">🦸‍♂️ Popular Characters</h4>
                <div class="row" id="character-results"></div>
            </section>
        </div>

        <!-- 📰 RIGHT COLUMN (Movie News) -->
        <div class="col-lg-5">
            <section id="movie-news" class="my-4">
                <h4 class="mb-3 border-bottom pb-2">📰 Latest Movie News</h4>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Never gonna give you up</h5>
                        <p class="card-text">Never gonna let you down, never tell a lie and hurt you.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Read more</a>
                    </div>
                </div>

                <!-- (More news cards here) -->
            </section>
        </div>

    </div>
</main>

<!-- Footer -->
<?php include_once 'footer.php'; ?>

<!-- 🔝 Back to Top Button -->
<button id="backToTopBtn" class="btn btn-primary position-fixed"
        style="top: 20px; left: 50%; transform: translateX(-50%); display: none; z-index: 1050;">
    ↑ Back to Top
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="js/home.js"></script>

</body>

</html>