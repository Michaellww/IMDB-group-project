<?php
session_start();
require __DIR__ . '/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$tconst = $_POST['tconst'] ?? null;
if ($tconst) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND tconst = ?");
    $stmt->execute([$_SESSION['user_id'], $tconst]);
}

header("Location: wishlist.php");
exit;
