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
    $seenNames = [];
    $stmt = $pdo->prepare("SELECT primaryName, primaryProfession FROM name_basics_trim WHERE primaryName LIKE :search || '%' COLLATE NOCASE ORDER BY primaryName");
    $stmt->execute(['search' => $searchTerm]);
    $peopleRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $people = [];

    foreach ($peopleRaw as $person) {
        $name = trim($person['primaryName']);
        if (in_array(strtolower($name), $seenNames)) continue;
        $seenNames[] = strtolower($name);

        $profession = trim($person['primaryProfession'] ?? '');
        if ($profession === '' || $profession === '\\N' || $profession === '\N') {
            $profession = '';
        } else {
            $profession = str_replace(['\\N', '_'], [' ', ' '], $profession);
            $profession = implode(", ", array_map('ucfirst', array_map('trim', explode(',', $profession))));
        }
        $person['primaryProfession'] = $profession;

        $people[] = [
            'primaryName' => $name,
            'primaryProfession' => $profession,
            'type' => 'person',
            'image' => getImageFromTMDb($name, false)
        ];

        if (count($people) >= 5) break;
    }

    $seenTitles = [];
    $stmt = $pdo->prepare("SELECT primaryTitle, genres FROM title_basics_trim WHERE primaryTitle LIKE :search || '%' COLLATE NOCASE ORDER BY primaryTitle");
    $stmt->execute(['search' => $searchTerm]);
    $titlesRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $titles = [];

    foreach ($titlesRaw as $title) {
        $titleName = trim($title['primaryTitle']);
        if (in_array(strtolower($titleName), $seenTitles)) continue;
        $seenTitles[] = strtolower($titleName);

        $genre = trim($title['genres'] ?? '');
        if ($genre === '' || $genre === '\\N' || $genre === '\N') {
            $genre = '';
        } else {
            $genre = str_replace(['\\N', '_'], [' ', ' '], $genre);
            $genre = implode(", ", array_map('ucfirst', array_map('trim', explode(',', $genre))));
        }
        $title['genres'] = $genre;

        $titles[] = [
            'primaryTitle' => $titleName,
            'genres' => $genre,
            'type' => 'title',
            'image' => getImageFromTMDb($titleName, true)
        ];

        if (count($titles) >= 5) break;
    }

    $results = array_merge($people, $titles);
}

echo json_encode($results);
