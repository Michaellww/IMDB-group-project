<?php
include_once __DIR__ . '/database.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    die("No title ID provided.");
}

$title = getTitle($id);
$cast = getTitleCast($id);

// TMDb API configuration
$tmdbApiKey = 'a89d53c18c2585eff159a3ee65bed7db'; // Replace with your actual TMDb API key
$tmdbApiUrl = 'https://api.themoviedb.org/3/search/movie?api_key=' . $tmdbApiKey . '&query=' . urlencode($title->primaryTitle);

// Initialize poster URL
$posterUrl = null;

// Fetch poster path from TMDb
$response = file_get_contents($tmdbApiUrl);
if ($response !== false) {
    $data = json_decode($response, true);
    if (!empty($data['results'])) {
        $posterPath = $data['results'][0]['poster_path'] ?? null;
        if ($posterPath) {
            $posterUrl = 'https://image.tmdb.org/t/p/w500' . $posterPath;
        }
    }
}
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
    <!-- Display movie poster -->
    <?php if ($posterUrl): ?>
        <img src="<?= htmlspecialchars($posterUrl) ?>" alt="Movie Poster" class="img-fluid mb-3" style="max-width: 500px; height: auto;" />
    <?php else: ?>
        <img src="images/default-poster.jpg" alt="Default Poster" class="img-fluid mb-3" style="max-width: 500px; height: auto;" />
    <?php endif; ?>

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
