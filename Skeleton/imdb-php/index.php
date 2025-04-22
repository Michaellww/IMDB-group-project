<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
-<main role="main" class="container bg-light">
    <!-- Navigation -->
    <? include_once 'navigation.php' ?>
    <main role="main" class="container-fluid px-4 bg-light">

        <!-- 🎬 Popular Movies -->
        <section class="my-5" id="popular-movies">
            <h3 class="mb-4 border-bottom pb-2">🎬 Popular Movies</h3>
            <div class="row" id="movie-results">
                <!-- Movie cards go here -->
            </div>
        </section>

        <!-- 🌟 Popular Actors -->
        <section class="my-5" id="popular-actors">
            <h3 class="mb-4 border-bottom pb-2">🌟 Popular Actors</h3>
            <div class="row" id="actor-results">
                <!-- Actor cards go here -->
            </div>
        </section>

        <!-- 🎂 Celebrity Birthdays Today -->
        <section class="my-5" id="birthday-celebs">
            <h3 class="mb-4 border-bottom pb-2">🎂 Birthdays Today</h3>
            <div class="row" id="birthday-results">
                <!-- Birthday cards go here -->
            </div>
        </section>

        <!-- ⭐ Top Rated Content -->
        <section class="my-5" id="top-rated">
            <h3 class="mb-4 border-bottom pb-2">⭐ Top Rated</h3>
            <div class="row" id="top-rated-results">
                <!-- Top rated items go here -->
            </div>
        </section>

        <!-- 🦸‍♂️ Popular Characters -->
        <section class="my-5" id="popular-characters">
            <h3 class="mb-4 border-bottom pb-2">🦸‍♂️ Popular Characters</h3>
            <div class="row" id="character-results">
                <!-- Character cards go here -->
            </div>
        </section>

    </main>
    <? include_once 'database.php'; ?>
    <!-- Footer -->
    <? include_once 'footer.php' ?>

</main>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="js/home.js"></script>
</body>
</html>