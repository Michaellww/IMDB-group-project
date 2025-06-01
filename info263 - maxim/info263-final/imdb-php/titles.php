<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require __DIR__ . '/database.php';
$pdo = getPDO();

$type = $_GET['type'] ?? null;
$page = $_GET['page'] ?? 1;
$startsWith = $_GET['starts_with'] ?? null;
$year = $_GET['year'] ?? null;
$rating = $_GET['rating'] ?? null;
$runtime = $_GET['runtime'] ?? null;

$offset = ($page - 1) * 60;
$titles = getTitles($type, $offset, 60, $startsWith, $year, $rating, $runtime);
$totalTitles = getTitleCount($type);

// Wishlist toggle (add/remove)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_toggle'], $_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $tconst = $_POST['wishlist_toggle'];

    $check = $pdo->prepare("SELECT 1 FROM wishlist WHERE user_id = ? AND tconst = ?");
    $check->execute([$userId, $tconst]);

    if ($check->fetch()) {
        $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND tconst = ?")->execute([$userId, $tconst]);
        echo json_encode(['status' => 'removed']);
    } else {
        $pdo->prepare("INSERT INTO wishlist (user_id, tconst) VALUES (?, ?)")->execute([$userId, $tconst]);
        echo json_encode(['status' => 'added']);
    }
    exit;
}

// Load current user's wishlist
$userWishlist = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT tconst FROM wishlist WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userWishlist = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>IMDB Titles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navigation.php'; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <div id="wishlistSidebar" style="display:none;position:fixed;right:0;top:0;width:300px;height:100%;background:#f8f9fa;padding:10px;overflow-y:auto;z-index:1050;">
        <h5>Your Wishlist</h5>
        <div id="wishlistContent">Loading...</div>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <!-- Add any filter UI here -->

    <?php if (empty($titles)): ?>
        <div class="alert alert-warning">No titles found!</div>
    <?php else: ?>
        <h2><?= htmlspecialchars($type ?? 'All') ?> Titles (<?= $totalTitles ?>)</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($titles as $title): ?>
                <?php $isInWishlist = in_array($title->tconst, $userWishlist); ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($title->primaryTitle) ?></h5>
                            <p class="card-text">
                                <?= $title->startYear ?> | <?= $title->runtimeMinutes ?? 'N/A' ?> mins<br>
                                Rating: <?= $title->rating ?? 'N/A' ?>
                            </p>
                            <div class="d-grid">
                                <button class="btn wishlist-button btn-sm <?= $isInWishlist ? 'btn-success' : 'btn-outline-success' ?>"
                                        data-tconst="<?= $title->tconst ?>">
                                    <?= $isInWishlist ? '✅ Added' : '➕ Add to Wishlist' ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-4">
    <div class="d-flex flex-wrap justify-content-center align-items-center mb-3">
        <?php
        $totalPages = ceil($totalTitles / 60);
        $visiblePages = [1, 2];
        for ($i = $page - 2; $i <= $page + 2; $i++) {
            if ($i > 2 && $i < $totalPages - 1) $visiblePages[] = $i;
        }
        $visiblePages[] = $totalPages - 1;
        $visiblePages[] = $totalPages;
        $visiblePages = array_unique(array_filter($visiblePages));
        sort($visiblePages);

        $baseLink = "titles.php?";
        if ($type) $baseLink .= "type=" . urlencode($type) . "&";
        if ($startsWith) $baseLink .= "starts_with=" . urlencode($startsWith) . "&";
        if ($year) $baseLink .= "year=" . urlencode($year) . "&";
        if ($rating) $baseLink .= "rating=" . urlencode($rating) . "&";
        if ($runtime) $baseLink .= "runtime=" . urlencode($runtime) . "&";

        if ($page > 1): ?>
            <a href="<?= $baseLink ?>page=<?= $page - 1 ?>" class="btn btn-outline-secondary btn-sm mx-1 mb-2">← Prev</a>
        <?php endif;

        $prev = 0;
        foreach ($visiblePages as $p):
            if ($p - $prev > 1) echo '<span class="mx-1">...</span>';
            $isCurrent = $p == $page;
            echo '<a href="' . $baseLink . 'page=' . $p . '" class="btn btn-sm ' . ($isCurrent ? 'btn-warning' : 'btn-outline-warning') . ' mx-1 mb-2">' . $p . '</a>';
            $prev = $p;
        endforeach;

        if ($page < $totalPages): ?>
            <a href="<?= $baseLink ?>page=<?= $page + 1 ?>" class="btn btn-outline-secondary btn-sm mx-1 mb-2">Next →</a>
        <?php endif; ?>
    </div>

    <!-- Jump-to-page -->
    <div class="d-flex justify-content-center">
        <form method="get" action="titles.php" class="d-flex align-items-center gap-2">
            <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
            <?php if ($startsWith): ?><input type="hidden" name="starts_with" value="<?= htmlspecialchars($startsWith) ?>"><?php endif; ?>
            <?php if ($year): ?><input type="hidden" name="year" value="<?= htmlspecialchars($year) ?>"><?php endif; ?>
            <?php if ($rating): ?><input type="hidden" name="rating" value="<?= htmlspecialchars($rating) ?>"><?php endif; ?>
            <?php if ($runtime): ?><input type="hidden" name="runtime" value="<?= htmlspecialchars($runtime) ?>"><?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('wishlistSidebar');
        const wishlistBtn = document.getElementById('toggleWishlist');
        const wishlistContent = document.getElementById('wishlistContent');

        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', () => {
                sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block';
                loadWishlist();
            });
        }

        document.querySelectorAll('.wishlist-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const tconst = btn.dataset.tconst;
                fetch('titles.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ wishlist_toggle: tconst })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'added') {
                            btn.textContent = '✅ Added';
                            btn.classList.remove('btn-outline-success');
                            btn.classList.add('btn-success');
                        } else {
                            btn.textContent = '➕ Add to Wishlist';
                            btn.classList.remove('btn-success');
                            btn.classList.add('btn-outline-success');
                        }
                        if (sidebar.style.display === 'block') loadWishlist();
                    });
            });
        });

        function loadWishlist() {
            fetch('wishlist_api.php')
                .then(res => res.json())
                .then(data => {
                    wishlistContent.innerHTML = data.length
                        ? data.map(item => `
                        <div class="wishlist-item mb-2">
                            <strong>${item.primaryTitle}</strong><br>
                            ${item.startYear} | ${item.runtimeMinutes ?? 'N/A'} mins
                            <button class="btn btn-sm btn-outline-danger mt-1 remove-wishlist" data-tconst="${item.tconst}">Remove</button>
                            <hr>
                        </div>
                    `).join('')
                        : "<p>No items in wishlist.</p>";

                    document.querySelectorAll('.remove-wishlist').forEach(button => {
                        button.addEventListener('click', function () {
                            const tconst = this.dataset.tconst;

                            fetch('titles.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams({ wishlist_toggle: tconst })
                            }).then(res => res.json()).then(data => {
                                if (data.status === 'removed') {
                                    loadWishlist();

                                    const gridBtn = document.querySelector(`.wishlist-button[data-tconst="${tconst}"]`);
                                    if (gridBtn) {
                                        gridBtn.textContent = '➕ Add to Wishlist';
                                        gridBtn.classList.remove('btn-success');
                                        gridBtn.classList.add('btn-outline-success');
                                    }
                                }
                            });
                        });
                    });
                });
        }
    });
</script>
<?php include_once 'footer.php'; ?>
</body>
</html>
