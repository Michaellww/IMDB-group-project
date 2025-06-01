<?php
require __DIR__ . '/database.php';
$genres = getAllGenres();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movie Genres - IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .genre-grid {
            column-count: 3;
            column-gap: 2rem;
        }
        .genre-item {
            break-inside: avoid-column;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .genre-grid {
                column-count: 2;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>
<?php if (isset($_SESSION['user_id'])): ?>
    <div id="wishlistSidebar" style="display:none;position:fixed;right:0;top:0;width:300px;height:100%;background:#f8f9fa;padding:10px;overflow-y:auto;z-index:1050;">
        <h5>Your Wishlist</h5>
        <div id="wishlistContent">Loading...</div>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="mb-4">🎭 Movie Genres</h2>

    <div class="genre-grid">
        <?php foreach ($genres as $genre): ?>
            <div class="genre-item">
                <a href="genre.php?name=<?= urlencode($genre) ?>"
                   class="btn btn-warning w-100 mb-2 text-start">
                    <?= htmlspecialchars($genre) ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script src="wishlist.js"></script>
</body>
</html>