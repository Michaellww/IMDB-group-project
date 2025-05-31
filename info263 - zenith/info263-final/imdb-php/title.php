<?php
include_once __DIR__ . '/database.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    die("No title ID provided.");
}

$title = getTitle($id);
$cast = getTitleCast($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title->primaryTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once 'navigation.php'; ?>

<div class="container mt-4">
    <!-- Always show this banner image -->
    <img src="images/starwars-login.jpg" alt="Movie Banner" class="img-fluid mb-3" style="max-width: 500px; height: auto;" />

    <!-- Movie info -->
    <h1><?= htmlspecialchars($title->primaryTitle) ?></h1>
    <p>
        <strong>Year:</strong> <?= htmlspecialchars($title->startYear) ?> |
        <strong>Runtime:</strong> <?= htmlspecialchars($title->runtimeMinutes) ?> mins |
        <strong>Genres:</strong> <?= htmlspecialchars($title->genres) ?> |
        <strong>Rating:</strong> <?= htmlspecialchars($title->rating ?? 'N/A') ?>
    </p>

    <!-- Cast -->
    <h3>Cast</h3>
    <?php if (empty($cast)): ?>
        <p>No cast information available.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php
            $seen = [];
            foreach ($cast as $person):
                if (in_array($person->primaryName, $seen)) continue;
                $seen[] = $person->primaryName;
                ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($person->primaryName) ?>
                    <?php
                    $chars = $person->characters;
                    if ($chars && $chars !== '\N') {
                        $decoded = json_decode($chars, true);
                        if (is_array($decoded)) {
                            echo ' as <em>' . htmlspecialchars(implode(', ', $decoded)) . '</em>';
                        } else {
                            echo ' as <em>' . htmlspecialchars($chars) . '</em>';
                        }
                    }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
