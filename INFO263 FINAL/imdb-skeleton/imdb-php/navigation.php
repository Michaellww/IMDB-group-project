<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FFD700;">
    <div class="container-fluid">
        <a class="navbar-brand p-2 fw-bold" href="index.php">IMDB 2</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav">
                <!-- Main Navigation -->
                <a class="nav-link p-2" href="titles.php?type=movie">Movies</a>
                <a class="nav-link p-2" href="titles.php?type=short">Shorts</a>
                <a class="nav-link p-2" href="titles.php?type=tvSeries">Series</a>
                <a class="nav-link p-2" href="people.php">People</a>
                <a class="nav-link p-2" href="genres.php">Genres</a>
                <a class="nav-link p-2" href="rankings.php">Rankings</a>

                <!-- Auth Section -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="nav-link p-2 disabled">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a class="nav-link p-2" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link p-2" href="login.php">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>