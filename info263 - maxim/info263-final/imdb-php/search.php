<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php'; // for TMDB_API_KEY

function fetchPoster($title) {
    $apiKey = TMDB_API_KEY;
    $query = urlencode($title);
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=$query";

    $json = @file_get_contents($url);
    $data = json_decode($json, true);

    if (!empty($data['results'][0]['poster_path'])) {
        return "https://image.tmdb.org/t/p/w185" . $data['results'][0]['poster_path'];
    }
    return null;
}

function fetchProfile($person) {
    $apiKey = TMDB_API_KEY;
    $query = urlencode($person);
    $url = "https://api.themoviedb.org/3/search/person?api_key=$apiKey&query=$query";

    $json = @file_get_contents($url);
    $data = json_decode($json, true);

    if (!empty($data['results'][0]['profile_path'])) {
        return "https://image.tmdb.org/t/p/w185" . $data['results'][0]['profile_path'];
    }
    return null;
}

try {
    $db = new PDO('sqlite:C:/Ampps/www/untitledfinal/info263 - zenith/info263-final/imdb-php/resources/imdb.2.sqlite3');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $_GET['query'] ?? '';
    $query = trim($query);
    $results = [];

    if ($query !== '') {
        $likeQuery = '%' . $query . '%';

        // 🎬 Search for movies
        $stmt = $db->prepare("SELECT primaryTitle AS name FROM title_basics_trim 
                              WHERE (primaryTitle LIKE :query OR originalTitle LIKE :query)
                              AND titleType = 'movie'
                              LIMIT 10");
        $stmt->execute([':query' => $likeQuery]);
        $movieResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($movieResults as $row) {
            $image = fetchPoster($row['name']) ?? null;
            $results[] = [
                'type' => 'Title (movie)',
                'name' => $row['name'],
                'image' => $image
            ];
        }

        // 👤 Search for people
        $stmt2 = $db->prepare("SELECT primaryName AS name FROM name_basics_trim 
                               WHERE primaryName LIKE :query
                               LIMIT 10");
        $stmt2->execute([':query' => $likeQuery]);
        $personResults = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($personResults as $row) {
            $image = fetchProfile($row['name']) ?? null;
            $results[] = [
                'type' => 'Person',
                'name' => $row['name'],
                'image' => $image
            ];
        }
    }

    echo json_encode($results);

} catch (Exception $e) {
    echo json_encode([]);
}
?>
