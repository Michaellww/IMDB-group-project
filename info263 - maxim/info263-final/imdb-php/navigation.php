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

        <div class="collapse navbar-collapse justify-content-between" id="mainNav">
            <div class="navbar-nav">
                <a class="nav-link p-2" href="titles.php?type=movie">Movies</a>
                <a class="nav-link p-2" href="titles.php?type=short">Shorts</a>
                <a class="nav-link p-2" href="titles.php?type=tvSeries">Series</a>
                <a class="nav-link p-2" href="people.php">People</a>
                <a class="nav-link p-2" href="genres.php">Genres</a>
                <a class="nav-link p-2" href="rankings.php">Rankings</a>
                <button id="toggleWishlist" class="btn btn-outline-dark btn-sm me-2">Wishlist</button>
            </div>

            <div class="navbar-nav ms-auto align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="nav-link disabled">👤 Logged in as: <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></span>
                    <a class="nav-link p-2" href="logout.php">Log Out</a>
                <?php else: ?>
                    <span class="nav-link disabled">👤 <span class="text-muted">Not logged in</span></span>
                    <a class="nav-link p-2" href="login.php">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Modal for login prompt -->
<div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginPromptLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You must be logged in to view your wishlist.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay Here</button>
                <a href="login.php" class="btn btn-primary">Log In</a>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Inject JS variable for login status -->
<script>
    const IS_LOGGED_IN = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>
