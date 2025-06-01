<?php
require_once 'config.php';


header('Content-Type: application/json');


$query = $_GET['query'] ?? '';
$query = trim($query);


if (!$query) {
    echo json_encode([]);
    exit;
}


$url = "https://api.themoviedb.org/3/search/multi?api_key=" . TMDB_API_KEY . "&language=en-US&query=" . urlencode($query) . "&include_adult=false";


$response = @file_get_contents($url);
if ($response === FALSE) {
    echo json_encode([]);
    exit;
}


$data = json_decode($response, true);


$results = [];
foreach ($data['results'] as $item) {
    $type = '';
    $name = '';
    $image = null;


    if ($item['media_type'] === 'movie') {
        $type = 'Title (movie)';
        $name = $item['title'] ?? 'Unknown';
        $image = $item['poster_path'] ?? null;
    } elseif ($item['media_type'] === 'tv') {
        $type = 'TV Show';
        $name = $item['name'] ?? 'Unknown';
        $image = $item['poster_path'] ?? null;
    } elseif ($item['media_type'] === 'person') {
        $type = 'Person';
        $name = $item['name'] ?? 'Unknown';
        $image = $item['profile_path'] ?? null; // ✅ Fixed: use profile_path
    } else {
        continue;
    }


    $results[] = [
        'name' => $name,
        'type' => $type,
        'image' => $image ? "https://image.tmdb.org/t/p/w185" . $image : null
    ];
}


echo json_encode($results);
exit;

