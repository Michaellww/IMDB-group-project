<?php include __DIR__ . '/database.php';
$title = getTitle($_GET['id']);
$cast = getTitleCast($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title->primaryTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="container mt-4">
    <h1><?= $title->primaryTitle ?></h1>
    <p>Year: <?= $title->startYear ?> • Runtime: <?= $title->runtimeMinutes ?> mins</p>

    <h3>Cast</h3>
    <div class="row row-cols-2 row-cols-md-3 g-4">
        <?php foreach ($cast as $person): ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5><?= $person->nconst ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>