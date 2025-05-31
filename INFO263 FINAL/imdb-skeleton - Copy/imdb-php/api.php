<?php
include_once 'database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$response = [];
$q = $_GET['q'] ?? '';

try {
    switch($q) {
        case 'titles':
            $offset = $_GET['offset'] ?? 0;
            $limit = $_GET['limit'] ?? 12;
            $title = $_GET['title'] ?? '';
            $type = $_GET['type'] ?? null;
            $sort = $_GET['sort'] ?? 'rating';
            $response = getTitles($offset, $limit, $title, $type, $sort);
            break;

        case 'people':
            $offset = $_GET['offset'] ?? 0;
            $limit = $_GET['limit'] ?? 24;
            $response = getPeople($offset, $limit);
            break;

        case 'title':
            $id = $_GET['id'] ?? '';
            $response = getTitle($id);
            break;

        default:
            $response = ['error' => 'Invalid query'];
    }

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}