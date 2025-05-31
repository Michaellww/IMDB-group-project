<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require __DIR__ . '/database.php';

$type = $_GET['type'] ?? null;
$page = $_GET['page'] ?? 1;
$startsWith = $_GET['starts_with'] ?? null;
$year = $_GET['year'] ?? null;
$rating = $_GET['rating'] ?? null;
$runtime = $_GET['runtime'] ?? null;

$offset = ($page - 1) * 60;

$titles = getTitles($type, $offset, 60, $startsWith, $year, $rating, $runtime);
$totalTitles = getTitleCount($type);
?>
<!DOCTYPE html>
<html>
<head>
    <title>IMDB Titles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="container mt-4">
    <form method="get" class="row g-3 mb-4">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

        <div class="col-md-3">
            <label class="form-label">Starts With</label>
            <select name="starts_with" class="form-select">
                <option value="">All</option>
                <?php foreach (range('A', 'Z') as $char): ?>
                    <option value="<?= $char ?>" <?= ($_GET['starts_with'] ?? '') === $char ? 'selected' : '' ?>><?= $char ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Year</label>
            <select name="year" class="form-select">
                <option value="">All</option>
                <?php foreach (range(2024, 1900, -1) as $y): ?>
                    <option value="<?= $y ?>" <?= ($_GET['year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select">
                <option value="">All</option>
                <?php foreach ([9,8,7,6,5,4,3,2,1] as $r): ?>
                    <option value="<?= $r ?>" <?= ($_GET['rating'] ?? '') == $r ? 'selected' : '' ?>><?= $r ?>+</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Runtime (min)</label>
            <select name="runtime" class="form-select">
                <option value="">All</option>
                <option value="0-30" <?= ($_GET['runtime'] ?? '') === '0-30' ? 'selected' : '' ?>>0–30</option>
                <option value="31-60" <?= ($_GET['runtime'] ?? '') === '31-60' ? 'selected' : '' ?>>31–60</option>
                <option value="61-90" <?= ($_GET['runtime'] ?? '') === '61-90' ? 'selected' : '' ?>>61–90</option>
                <option value="91-120" <?= ($_GET['runtime'] ?? '') === '91-120' ? 'selected' : '' ?>>91–120</option>
                <option value="121+" <?= ($_GET['runtime'] ?? '') === '121+' ? 'selected' : '' ?>>>120</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>

    <?php if (empty($titles)): ?>
        <div class="alert alert-warning">No titles found!</div>
    <?php else: ?>
        <h2><?= htmlspecialchars($type ?? 'All') ?> Titles (<?= $totalTitles ?>)</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($titles as $title): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($title->primaryTitle) ?></h5>
                            <p class="card-text">
                                <?= $title->startYear ?> | <?= $title->runtimeMinutes ?> mins<br>
                                Rating: <?= $title->rating ?? 'N/A' ?>
                            </p>
                            <div class="d-grid gap-2 mt-2">
                                <button class="btn btn-outline-success btn-sm wishlist-button" data-tconst="<?= $title->tconst ?>">
                                    ➕ Add to Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You must be logged in to add items to your wishlist.
            </div>
            <div class="modal-footer">
                <a href="login.php" class="btn btn-primary">Go to Login</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.wishlist-button').forEach(button => {
            button.addEventListener('click', function () {
                <?php if (isset($_SESSION['user_id'])): ?>
                const tconst = this.dataset.tconst;
                fetch('titles.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: new URLSearchParams({ wishlist_add: tconst })
                }).then(() => {
                    this.textContent = '✅ Added';
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success');
                    this.disabled = true;
                });
                <?php else: ?>
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                <?php endif; ?>
            });
        });
    });
</script>
</body>
<?php include_once 'footer.php'; ?>
</html>