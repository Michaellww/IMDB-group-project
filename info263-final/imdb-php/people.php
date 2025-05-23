<?php
require __DIR__ . '/database.php';

$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * 24;
$people = getPeople($offset);
?>
<!DOCTYPE html>
<html>
<head>
    <title>IMDB People</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>
<div class="container mt-4">
    <h2>People</h2>
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
        <?php foreach ($people as $person): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $person->primaryName ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>