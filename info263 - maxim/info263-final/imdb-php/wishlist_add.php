// wishlist_add.php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Not logged in";
    exit;
}

$tconst = $_POST['wishlist_add'] ?? null;
if ($tconst) {
    require_once 'database.php';
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO wishlist (user_id, tconst) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $tconst]);
    echo "Added";
} else {
    http_response_code(400);
    echo "Invalid input";
}
