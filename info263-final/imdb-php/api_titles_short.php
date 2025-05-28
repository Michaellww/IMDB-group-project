<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'database.php';

$titles = getTitles('short', 0, 9);
echo json_encode($titles);
