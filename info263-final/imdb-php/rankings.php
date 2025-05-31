<?php
require __DIR__ . '/database.php';

try {
    $page = $_GET['page'] ?? 1;
    $offset = ($page - 1) * 20;
    $movies = getTopRatedMovies($offset);
    $totalMovies = getTotalMoviesCount();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Top Rated Movies - IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ranking-badge {
            background: #ffc107;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.2s;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">🏆 Top Rated Movies</h2>

    <?php if(empty($movies)): ?>
        <div class="alert alert-warning">No movies found in the rankings!</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($movies as $index => $movie): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="ranking-badge">
                                    <?= $index + 1 + $offset ?>
                                </div>
                                <div class="text-warning">
                                    ★ <?= number_format($movie->averageRating, 1) ?>
                                    <small class="text-muted">(<?= number_format($movie->numVotes) ?> votes)</small>
                                </div>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($movie->primaryTitle) ?></h5>
                            <p class="card-text">
                                <?= $movie->startYear ?> • <?= $movie->runtimeMinutes ?? 'N/A' ?> mins
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            <?php for ($i = 1; $i <= ceil($totalMovies / 20); $i++): ?>
                <a href="rankings.php?page=<?= $i ?>"
                   class="btn btn-sm <?= $i == $page ? 'btn-warning' : 'btn-outline-warning' ?> mx-1">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>