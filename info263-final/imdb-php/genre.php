<?php
require __DIR__ . '/database.php';

$genre = $_GET['name'] ?? '';
if (empty($genre)) {
    header('Location: genres.php');
    exit;
}

$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * 20;

try {
    $movies = getMoviesByGenre($genre, $offset);
    $totalMovies = getGenreMovieCount($genre);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($genre) ?> Movies - IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.2s;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">🎬 <?= htmlspecialchars($genre) ?> Movies</h2>

    <?php if(empty($movies)): ?>
        <div class="alert alert-warning">No movies found in this genre!</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($movies as $movie): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie->primaryTitle) ?></h5>
                            <p class="card-text">
                                <?= $movie->startYear ?> • <?= $movie->runtimeMinutes ?? 'N/A' ?> mins<br>
                                <span class="text-warning">★ <?= number_format($movie->averageRating, 1) ?></span>
                            </p>
                            <a href="title.php?id=<?= $movie->tconst ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= ceil($totalMovies / 20); $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="genre.php?name=<?= urlencode($genre) ?>&page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>