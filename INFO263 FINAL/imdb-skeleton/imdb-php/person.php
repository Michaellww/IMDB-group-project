<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Person Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
include 'navigation.php';
include 'database.php';

$person = getPersonDetails($_GET['id']);
$titles = getPersonTitles($_GET['id']);
?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <img src="person-placeholder.jpg" class="card-img-top" alt="Profile">
            </div>
        </div>
        <div class="col-md-9">
            <h1><?= htmlspecialchars($person->primaryName) ?></h1>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="h5">🎂 <?= $person->birthYear ?? 'Unknown' ?></div>
                    <small class="text-muted">Birth Year</small>
                </div>
                <div class="col-md-4">
                    <div class="h5">⚰️ <?= $person->deathYear ?? 'N/A' ?></div>
                    <small class="text-muted">Death Year</small>
                </div>
            </div>

            <h3 class="mt-4">Filmography</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($titles as $title): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($title->primaryTitle) ?></h5>
                                <p class="card-text">
                                    <span class="badge bg-primary"><?= $title->titleType ?></span>
                                    <span class="text-muted ms-2"><?= $title->startYear ?></span>
                                </p>
                                <a href="title.php?id=<?= $title->tconst ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>