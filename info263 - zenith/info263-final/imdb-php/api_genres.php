<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'database.php';

$genres = getAllGenres();
echo json_encode($genres);
