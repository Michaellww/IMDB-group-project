<?php
header("Content-Type: application/json");
require_once 'config.php';

$pdo = new PDO("sqlite:C:/Users/terre/IMDB/INFO263 FINAL/imdb-skeleton/imdb-php/resources/imdb.2.sqlite3");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$results = [];

function getImageFromTMDb($name, $isMovie = false) {
    $base = "https://api.themoviedb.org/3/search/" . ($isMovie ? "movie" : "person");
    $query = http_build_query([
        "api_key" => TMDB_API_KEY,
        "query" => $name
    ]);
    $url = "$base?$query";

    $json = @file_get_contents($url);
    if (!$json) return null;
    $data = json_decode($json, true);
    $path = $data['results'][0][$isMovie ? 'poster_path' : 'profile_path'] ?? null;

    return $path ? "https://image.tmdb.org/t/p/w92$path" : null;
}

if ($searchTerm !== '') {
    // Person search
    $stmt = $pdo->prepare("SELECT DISTINCT primaryName, primaryProfession FROM name_basics_trim WHERE primaryName LIKE :search || '%' COLLATE NOCASE ORDER BY primaryName LIMIT 5");
    $stmt->execute(['search' => $searchTerm]);
    $people = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($people as &$person) {
        $person['type'] = 'person';
        $person['image'] = getImageFromTMDb($person['primaryName'], false);
        $profession = trim($person['primaryProfession'] ?? '');
        $profession = str_replace('_', ' ', $profession);
        $profession = ucwords(strtolower($profession));
        $person['primaryProfession'] = str_replace(",", ", ", $profession); // Add space after commas
        if ($profession === '' || $profession === '\\N' || strtoupper($profession) === '\N') {
            $profession = 'Unknown';
        }
    }

    // Title search
    $stmt = $pdo->prepare("SELECT DISTINCT primaryTitle, genres FROM title_basics_trim WHERE primaryTitle LIKE :search || '%' COLLATE NOCASE ORDER BY primaryTitle LIMIT 5");
    $stmt->execute(['search' => $searchTerm]);
    $titles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($titles as &$title) {
        $title['type'] = 'title';
        $title['image'] = getImageFromTMDb($title['primaryTitle'], true);
        $genre = trim($title['genres'] ?? '');
        $genre = str_replace('_', ' ', $genre);
        $title['genres'] = str_replace(",", ", ", $genre); // Add space after commas
        if ($genre === '' || $genre === '\\N' || strtoupper($genre) === '\N') {
            $genre = 'Unknown';
        }
    }

    $results = array_merge($people, $titles);
}

echo json_encode($results);
