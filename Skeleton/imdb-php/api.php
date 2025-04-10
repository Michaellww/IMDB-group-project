<?php

include_once 'database.php';

/***************
 * Add headers *
 ***************/

// clear the old headers
header_remove();

// CORS - NOTE: Change this link to the React page to avoid CORS warnings
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: 'Origin, X-Requested-With, Content-Type, Accept'");
header("Access-Control-Allow-Methods: 'GET, POST'");

// set the header to make sure cache is forced
header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
// treat this as json
header('Content-Type: application/json');

if (isset($_GET['offset']) and !empty($_GET['offset'])) {
    $offset = $_GET["offset"];
} else {
    $offset = 0;
}

if (isset($_GET['limit']) and !empty($_GET['limit'])) {
    $limit = $_GET["limit"];
} else {
    $limit = 12;
}

if (isset($_GET['title']) and !empty($_GET['title'])) {
    $title = $_GET["title"];
}

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $id = $_GET["id"];
}

if (isset($_GET['q']) and !empty($_GET['q'])) {
    $q = $_GET['q'];

    if ($q == "titles") {
        $titles = getTitles($offset, $limit, $title);
        echo json_encode(new ArrayValue($titles), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }
    if ($q == "title_count") {
        $title_count = getTitleCount($title);
        echo json_encode(new ArrayValue(['title_count' => $title_count]), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }
    if ($q == "title") {
        $title = getTitle($id);
        echo json_encode($title, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }
}

?>