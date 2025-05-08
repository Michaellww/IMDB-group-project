<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB</title>
    <!-- Favicon for browser tab -->
    <link rel="icon" type="image/png" href="../images/favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navigation -->
<?php include_once 'navigation.php'; ?>

<!-- Main Layout -->
<main class="bg-light flex-grow-1">
    <div class="container">
        <div class="row">

            <!-- 🧱 LEFT COLUMN (Base layout) -->
            <div class="col-lg-7">
                <!-- Sections like Popular Movies, Actors, etc. -->
                <section id="popular-movies" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2 d-flex align-items-center">
                        🎬
                        <a href="#" data-bs-toggle="modal" data-bs-target="#allMoviesModal" class="d-inline-flex align-items-center ms-1 text-decoration-none text-dark">
                            Popular Movies
                            <span class="ms-1">&#9656;</span> <!-- Unicode black right-pointing triangle -->
                        </a>
                    </h4>


                    <div class="d-flex overflow-auto gap-3 py-2" id="movie-results">
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="The Godfather">The Godfather</h6>
                                <p class="card-text mb-1">1972</p>
                                <p class="card-text text-muted small">Crime, Drama</p>
                            </div>
                        </div>
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Pulp Fiction">Pulp Fiction</h6>
                                <p class="card-text mb-1">1994</p>
                                <p class="card-text text-muted small">Crime, Thriller</p>
                            </div>
                        </div>
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Inception">Inception</h6>
                                <p class="card-text mb-1">2010</p>
                                <p class="card-text text-muted small">Action, Sci-Fi</p>
                            </div>
                        </div>
                        <!-- Add more cards as needed -->
                    </div>
                    <!-- Add this anywhere near the end of <body> -->
                    <div class="modal fade" id="allMoviesModal" tabindex="-1" aria-labelledby="allMoviesLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="allMoviesLabel">🎬 Full Movie List</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                                            <!-- Example movie title -->
                                            <div class="col"><div class="p-2 border rounded text-center">Shiva und die Galgenblume</div></div>
                                            <div class="col"><div class="p-2 border rounded text-center">Let There Be Light</div></div>
                                            <div class="col"><div class="p-2 border rounded text-center">Nagarik</div></div>
                                            <div class="col"><div class="p-2 border rounded text-center">Rosa blanca</div></div>
                                            <div class="col"><div class="p-2 border rounded text-center">Gregorio and His Angel</div></div>
                                            <!-- Repeat div.col for each title -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <section id="popular-actors" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2">🌟 Popular Actors</h4>
                    <div class="d-flex overflow-auto gap-3 py-2" id="actor-results">
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Robert De Niro">Robert De Niro</h6>
                                <p class="card-text mb-1">Born: 1943</p>
                                <p class="card-text text-muted small">actor, producer, director</p>
                            </div>
                        </div>
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Meryl Streep">Meryl Streep</h6>
                                <p class="card-text mb-1">Born: 1949</p>
                                <p class="card-text text-muted small">actress, producer</p>
                            </div>
                        </div>
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Leonardo DiCaprio">Leonardo DiCaprio</h6>
                                <p class="card-text mb-1">Born: 1974</p>
                                <p class="card-text text-muted small">producer, actor, writer</p>
                            </div>
                        </div>
                        <!-- Add more actor cards here -->
                    </div>
                </section>

                <section id="birthday-celebs" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2">🎂 Birthdays Today</h4>
                    <div class="row" id="birthday-results"></div>
                </section>

                <section id="top-rated-movies" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2">⭐ Top Rated Movies</h4>

                    <div class="d-flex overflow-auto gap-3 py-2" id="rating-results">
                        <!-- Example card -->
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="The Godfather">The Godfather</h6>
                                <p class="card-text mb-1">1972</p>
                                <p class="card-text text-muted small">Crime, Drama</p>
                                <p class="card-text text-muted small">⭐ 9.2 | 1,567,420 votes</p>
                            </div>
                        </div>

                        <!-- Repeat similar cards for each top-rated movie -->
                        <!-- Use JS/PHP to loop over results from SQL query -->

                    </div>
                </section>

                <section id="popular-characters" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2">🎭 Popular Characters</h4>

                    <div class="d-flex overflow-auto gap-3 py-2" id="character-results">
                        <!-- Example card -->
                        <div class="card shadow-sm" style="min-width: 200px;">
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="Tarô">Tarô</h6>
                                <p class="card-text mb-1">1979</p>
                                <p class="card-text text-muted small">from <i>Taro the Dragon Boy</i></p>
                            </div>
                        </div>

                        <!-- Repeat for each character -->
                    </div>
                </section>

            </div>

            <!-- 📰 RIGHT COLUMN (Movie News) -->
            <div class="col-lg-5">
                <section id="movie-news" class="my-4 section-margin">
                    <h4 class="mb-3 pb-2">📰 Latest Movie News</h4>

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
    </div>
</main>

<!-- Footer -->
<?php include_once 'footer.php'; ?>

<!-- 🔝 Back to Top Button -->
<button id="backToTopBtn" class="btn btn-primary position-fixed"
        style="top: 70px; left: 50%; transform: translateX(-50%); display: none; z-index: 1050;">
    ↑ Back to Top
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="../js/home.js"></script>
<script src="../js/names.js"></script>

</body>

</html>