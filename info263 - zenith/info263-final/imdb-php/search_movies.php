<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', 'mysql', 'imdb');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$q = $conn->real_escape_string($_GET['q']);

$sql = "
    SELECT tb.primaryTitle, tb.startYear, tr.averageRating, tr.numVotes
    FROM title_basics_trim tb
    LEFT JOIN title_rating_trim tr ON tb.tconst = tr.tconst
    WHERE tb.primaryTitle LIKE '%$q%'
    ORDER BY tr.numVotes DESC
    LIMIT 10
";

$result = $conn->query($sql);

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

