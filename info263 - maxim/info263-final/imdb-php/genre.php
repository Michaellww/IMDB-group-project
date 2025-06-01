<?php
require __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_toggle'], $_SESSION['user_id'])) {
    $pdo = getPDO();
    $tconst = $_POST['wishlist_toggle'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT 1 FROM wishlist WHERE user_id = ? AND tconst = ?");
    $stmt->execute([$userId, $tconst]);

    if ($stmt->fetch()) {
        $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND tconst = ?")->execute([$userId, $tconst]);
        echo json_encode(['status' => 'removed']);
    } else {
        $pdo->prepare("INSERT INTO wishlist (user_id, tconst) VALUES (?, ?)")->execute([$userId, $tconst]);
        echo json_encode(['status' => 'added']);
    }
    exit;
}

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

<?php if (isset($_SESSION['user_id'])): ?>
    <div id="wishlistSidebar" style="display:none;position:fixed;right:0;top:0;width:300px;height:100%;background:#f8f9fa;padding:10px;overflow-y:auto;z-index:1050;">
        <h5>Your Wishlist</h5>
        <div id="wishlistContent">Loading...</div>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="mb-4">🎬 <?= htmlspecialchars($genre) ?> Movies</h2>

    <?php if(empty($movies)): ?>
        <div class="alert alert-warning">No movies found in this genre!</div>
    <?php else: ?>
        <?php
        $userWishlist = [];
        if (isset($_SESSION['user_id'])) {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT tconst FROM wishlist WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $userWishlist = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        ?>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($movies as $movie): ?>
                <?php $isInWishlist = in_array($movie->tconst, $userWishlist); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="title.php?id=<?= urlencode($movie->tconst) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($movie->primaryTitle) ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <?= $movie->startYear ?> • <?= $movie->runtimeMinutes ?? 'N/A' ?> mins<br>
                                <span class="text-warning">★ <?= number_format($movie->averageRating, 1) ?></span>
                            </p>
                            <div class="d-grid gap-2 mt-2">
                                <?php $isInWishlist = in_array($movie->tconst, $userWishlist); ?>
                                <button class="btn wishlist-button btn-sm <?= $isInWishlist ? 'btn-success' : 'btn-outline-success' ?>"
                                        data-tconst="<?= $movie->tconst ?>">
                                    <?= $isInWishlist ? '✅ Added' : '➕ Add to Wishlist' ?>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination (same improved version as rankings.php) -->
        <div class="mt-4">
            <div class="d-flex flex-wrap justify-content-center align-items-center mb-3">
                <?php
                $totalPages = ceil($totalMovies / 20);
                $visiblePages = [];

                $visiblePages[] = 1;
                $visiblePages[] = 2;
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i > 2 && $i < $totalPages - 1) {
                        $visiblePages[] = $i;
                    }
                }
                $visiblePages[] = $totalPages - 1;
                $visiblePages[] = $totalPages;

                $visiblePages = array_unique(array_filter($visiblePages));
                sort($visiblePages);

                if ($page > 1): ?>
                    <a href="genre.php?name=<?= urlencode($genre) ?>&page=<?= $page - 1 ?>" class="btn btn-outline-secondary btn-sm mx-1 mb-2">← Prev</a>
                <?php endif;

                $prev = 0;
                foreach ($visiblePages as $p):
                    if ($p - $prev > 1) {
                        echo '<span class="mx-1">...</span>';
                    }
                    $isCurrent = $p == $page;
                    echo '<a href="genre.php?name=' . urlencode($genre) . '&page=' . $p . '" class="btn btn-sm ' . ($isCurrent ? 'btn-warning' : 'btn-outline-warning') . ' mx-1 mb-2">' . $p . '</a>';
                    $prev = $p;
                endforeach;

                if ($page < $totalPages): ?>
                    <a href="genre.php?name=<?= urlencode($genre) ?>&page=<?= $page + 1 ?>" class="btn btn-outline-secondary btn-sm mx-1 mb-2">Next →</a>
                <?php endif; ?>
            </div>

            <!-- Jump-to-page -->
            <div class="d-flex justify-content-center">
                <form method="get" action="genre.php" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($genre) ?>">
                    <label for="jumpPage" class="form-label mb-0">Jump to:</label>
                    <select id="jumpPage" name="page" class="form-select form-select-sm" style="width:auto;">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <option value="<?= $i ?>" <?= $i == $page ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Go</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include_once 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="wishlist.js"></script>
</body>
</html>
