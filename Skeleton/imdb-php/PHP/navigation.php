<?php
#session_start();
$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? htmlspecialchars($_SESSION['user']['email']) : "Not logged in";
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-1000">
    <div class="container px-5">
        <a class="navbar-brand" href="#">IMDB Project</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#popular-movies">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#popular-actors">Actors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#top-rated">Top Rated</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#popular-characters">Characters</a>
                </li>
            </ul>

            <!-- Profile button and login status -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-light d-flex align-items-center"
                        onclick="<?= $loggedIn ? 'window.location.href=\'profile.php\'' : 'promptLogin()' ?>"
                        style="border-radius: 50%;">
                <img src="../images/avatarpl.png" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%;">
                </button>
                <span class="text-white small"><?= $username ?></span>
            </div>

            <form class="d-flex position-relative" role="search" action="search.php" method="get">
                <input name="query" id="searchInput" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn btn-warning" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<!-- Include the names.js script -->
<script src="../js/names.js"></script>
