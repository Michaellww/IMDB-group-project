<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/database.php';

// Debugging output
echo "<!-- Debug: Script started -->";

try {
    $type = $_GET['type'] ?? null;
    $page = $_GET['page'] ?? 1;
    $offset = ($page - 1) * 12;

    echo "<!-- Debug: Type = $type -->";
    echo "<!-- Debug: Offset = $offset -->";

    $titles = getTitles($type, $offset);
    $totalTitles = getTitleCount($type);

    echo "<!-- Debug: Titles count = " . count($titles) . " -->";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
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
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>