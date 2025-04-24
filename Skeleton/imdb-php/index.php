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
-<main role="main">
    <!-- Navigation -->
    <? include_once 'navigation.php' ?>
    <main class="px-4 bg-light" style="margin-top: -35px;">
        <div class="row">
            <!-- 🧱 LEFT COLUMN (Base layout) -->
            <div class="col-lg-7">
                <!-- 🎬 Popular Movies -->
                <section class="my-4" id="popular-movies">
                    <h4 class="mb-3 border-bottom pb-2">🎬 Popular Movies</h4>
                    <div class="row" id="movie-results">
                        <!-- Movie cards here -->
                    </div>
                </section>

                <!-- 🌟 Popular Actors -->
                <section class="my-4" id="popular-actors">
                    <h4 class="mb-3 border-bottom pb-2">🌟 Popular Actors</h4>
                    <div class="row" id="actor-results">
                        <!-- Actor cards here -->
                    </div>
                </section>

                <!-- 🎂 Birthdays -->
                <section class="my-4" id="birthday-celebs">
                    <h4 class="mb-3 border-bottom pb-2">🎂 Birthdays Today</h4>
                    <div class="row" id="birthday-results">
                        <!-- Cards here -->
                    </div>
                </section>

                <!-- ⭐ Ratings -->
                <section class="my-4" id="top-rated">
                    <h4 class="mb-3 border-bottom pb-2">⭐ Top Rated</h4>
                    <div class="row" id="top-rated-results">
                        <!-- Cards here -->
                    </div>
                </section>

                <!-- 🦸‍♂️ Characters -->
                <section class="my-4" id="popular-characters">
                    <h4 class="mb-3 border-bottom pb-2">🦸‍♂️ Popular Characters</h4>
                    <div class="row" id="character-results">
                        <!-- Cards here -->
                    </div>
                </section>
            </div>

            <!-- 📰 RIGHT COLUMN (Movie News) -->
            <div class="col-lg-5">
                <section class="my-4" id="movie-news">
                    <h4 class="mb-3 border-bottom pb-2">📰 Latest Movie News</h4>

                    <!-- Example News Card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Never gonna give you up</h5>
                            <p class="card-text">Never gonna let you down, never tell a lie and hurt you.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Read more</a>
                        </div>
                    </div>

                    <!-- Add more news blocks here -->
                </section>
            </div>

        </div>
    </main>

    <? include_once 'database.php'; ?>
    <!-- Footer -->
    <? include_once 'footer.php' ?>

</main>
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