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
<?php if (isset($_SESSION['user_id'])): ?>
    <div id="wishlistSidebar" style="display:none;position:fixed;right:0;top:0;width:300px;height:100%;background:#f8f9fa;padding:10px;overflow-y:auto;z-index:1050;">
        <h5>Your Wishlist</h5>
        <div id="wishlistContent">Loading...</div>
        <button class="btn btn-danger btn-sm mt-2" id="clearWishlistBtn">Clear Wishlist</button>
        <button class="btn btn-warning btn-sm mt-2 d-none" id="undoBtn">Undo</button>
    </div>
<?php endif; ?>
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
<?php include_once 'footer.php'; ?>
<script src="wishlist.js"></script>
</body>
</html>