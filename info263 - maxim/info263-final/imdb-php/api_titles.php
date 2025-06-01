<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'database.php';

$type = $_GET['type'] ?? null;
$offset = 0;
$limit = 9;

$titles = getTitles($type, $offset, $limit);
echo json_encode($titles);
