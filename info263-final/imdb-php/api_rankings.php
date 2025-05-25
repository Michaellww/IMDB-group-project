<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'database.php';

$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * 20;

$movies = getTopRatedMovies($offset);
echo json_encode($movies);
