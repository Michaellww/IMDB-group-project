<?php
session_start();
require_once 'connection.php';
$pdo = getPDO();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT b.tconst, b.primaryTitle, b.startYear, b.runtimeMinutes
    FROM wishlist w
    JOIN title_basics_trim b ON w.tconst = b.tconst
    WHERE w.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
