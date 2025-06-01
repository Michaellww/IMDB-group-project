<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'database.php';

$genre = $_GET['genre'] ?? '';
if ($genre === '') {
    echo json_encode([]);
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare("
    SELECT t.primaryTitle, t.startYear, t.runtimeMinutes, r.averageRating
    FROM title_basics_trim t
    JOIN title_ratings_trim r ON t.tconst = r.tconst
    WHERE t.genres LIKE :genre
    ORDER BY r.averageRating DESC
    LIMIT 50
");
$stmt->execute(['genre' => "%$genre%"]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
