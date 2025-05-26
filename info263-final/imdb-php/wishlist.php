<?php
session_start();
require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=wishlist.php");
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare("
    SELECT t.tconst, t.primaryTitle, t.startYear, t.runtimeMinutes, r.averageRating
    FROM wishlist w
    JOIN title_basics_trim t ON w.tconst = t.tconst
    LEFT JOIN title_ratings_trim r ON t.tconst = r.tconst
    WHERE w.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$wishlist = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist - IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="container mt-4">
    <h2>My Wishlist</h2>
    <?php if (empty($wishlist)): ?>
        <div class="alert alert-info">You have no items in your wishlist yet.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Runtime</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($wishlist as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->primaryTitle) ?></td>
                    <td><?= $item->startYear ?></td>
                    <td><?= $item->runtimeMinutes ?> mins</td>
                    <td><?= $item->averageRating ?? 'N/A' ?></td>
                    <td>
                        <form method="POST" action="remove_wishlist.php" onsubmit="return confirm('Remove this item from wishlist?');">
                            <input type="hidden" name="tconst" value="<?= htmlspecialchars($item->tconst) ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
