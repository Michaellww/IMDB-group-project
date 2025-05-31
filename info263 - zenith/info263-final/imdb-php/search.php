<?php
header('Content-Type: application/json; charset=utf-8');

try {
    $db = new PDO('sqlite:imdb.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $_GET['query'] ?? '';
    $query = trim($query);

    $results = [];

    if ($query !== '') {
        $likeQuery = '%' . $query . '%';

        $stmt = $db->prepare("SELECT primaryTitle AS name FROM title_basics_trim 
                              WHERE (primaryTitle LIKE :query OR originalTitle LIKE :query)
                              AND titleType = 'movie'
                              LIMIT 10");
        $stmt->execute([':query' => $likeQuery]);
        $movieResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($movieResults as $row) {
            $results[] = [
                'type' => 'Title (movie)',
                'name' => $row['name']
            ];
        }

        // 搜索人名
        $stmt2 = $db->prepare("SELECT primaryName AS name FROM name_basics_trim 
                               WHERE primaryName LIKE :query
                               LIMIT 10");
        $stmt2->execute([':query' => $likeQuery]);
        $personResults = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($personResults as $row) {
            $results[] = [
                'type' => 'person',
                'name' => $row['name']
            ];
        }
    }

    echo json_encode($results);

} catch (Exception $e) {
    echo json_encode([]);
}


