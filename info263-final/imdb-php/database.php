<?php
require_once __DIR__ . '/connection.php';

function getTitles($type = null, $offset = 0, $limit = 12, $startsWith = null, $year = null, $rating = null, $runtime = null) {
    $pdo = getPDO();
    $sql = "SELECT t.tconst, t.primaryTitle, t.startYear, t.runtimeMinutes, r.averageRating as rating
            FROM title_basics_trim t
            JOIN title_ratings_trim r ON t.tconst = r.tconst
            WHERE 1=1";

    $params = [];

    if ($type) {
        $sql .= " AND t.titleType = :type";
        $params[':type'] = $type;
    }

    if ($startsWith) {
        $sql .= " AND t.primaryTitle LIKE :startsWith";
        $params[':startsWith'] = "$startsWith%";
    }

    if ($year) {
        $sql .= " AND t.startYear = :year";
        $params[':year'] = $year;
    }

    if ($rating) {
        $sql .= " AND r.averageRating >= :rating";
        $params[':rating'] = $rating;
    }

    if ($runtime) {
        if ($runtime === '121+') {
            $sql .= " AND t.runtimeMinutes > 120";
        } elseif (preg_match('/^(\d+)-(\d+)$/', $runtime, $m)) {
            $sql .= " AND t.runtimeMinutes BETWEEN :runtimeMin AND :runtimeMax";
            $params[':runtimeMin'] = $m[1];
            $params[':runtimeMax'] = $m[2];
        }
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    try {
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching titles: " . $e->getMessage());
    }
}


function getPeople($offset = 0, $limit = 24) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("SELECT * FROM name_basics_trim LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching people: " . $e->getMessage());
    }
}
function getTitleCount($type = null) {
    $pdo = getPDO();
    $sql = "SELECT COUNT(*) FROM title_basics_trim";
    if ($type) $sql .= " WHERE titleType = :type";

    try {
        $stmt = $pdo->prepare($sql);
        if ($type) $stmt->bindValue(':type', $type);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        die("Error counting titles: " . $e->getMessage());
    }
}

// Add this function
function createUsersTable() {
    $pdo = getPDO();
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

// Add this at the bottom of database.php
createUsersTable();

function getAllGenres() {
    $pdo = getPDO();
    $stmt = $pdo->query("
        SELECT genres
        FROM title_basics_trim
        WHERE genres != '\N'
    ");

    $allGenres = [];
    while ($row = $stmt->fetch()) {
        $genres = explode(',', $row->genres);
        foreach ($genres as $genre) {
            $cleanGenre = trim($genre);
            if (!empty($cleanGenre)) {
                $allGenres[] = $cleanGenre;
            }
        }
    }

    $uniqueGenres = array_unique($allGenres);
    sort($uniqueGenres);

    return $uniqueGenres;
}

require_once __DIR__ . '/connection.php';

function getPDO(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                CONNECTION_STRING,
                CONNECTION_USER,
                CONNECTION_PASSWORD,
                CONNECTION_OPTIONS
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

function registerUser($name, $email, $password)
{
    $pdo = getPDO();

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception('Email already registered');
    }

    // Validate password
    if (strlen($password) < 8) {
        throw new Exception('Password must be at least 8 characters');
    }

    // Create user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hash]);
    return $pdo->lastInsertId();
}

function authenticateUser($email, $password)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user->password_hash)) {
        return $user;
    }
    return false;
}

function getMoviesByGenre($genre, $offset = 0, $limit = 20) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("
            SELECT t.tconst, t.primaryTitle, t.startYear, t.runtimeMinutes, r.averageRating
            FROM title_basics_trim t
            JOIN title_ratings_trim r ON t.tconst = r.tconst
            WHERE genres LIKE ?
            ORDER BY r.averageRating DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute(["%$genre%", $limit, $offset]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching genre movies: " . $e->getMessage());
    }
}

function getGenreMovieCount($genre) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM title_basics_trim 
            WHERE genres LIKE ?
        ");
        $stmt->execute(["%$genre%"]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        die("Error counting genre movies: " . $e->getMessage());
    }
}

function getTopRatedMovies($offset = 0, $limit = 20) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("
            SELECT t.tconst, t.primaryTitle, t.startYear, t.runtimeMinutes, 
                   r.averageRating, r.numVotes
            FROM title_basics_trim t
            JOIN title_ratings_trim r ON t.tconst = r.tconst
            WHERE t.titleType = 'movie' 
              AND r.averageRating IS NOT NULL
            ORDER BY r.averageRating DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw new Exception("Error fetching rankings: " . $e->getMessage());
    }
}

function getTotalMoviesCount() {
    $pdo = getPDO();
    try {
        return $pdo->query("
            SELECT COUNT(*) 
            FROM title_basics_trim 
            WHERE titleType = 'movie'
        ")->fetchColumn();
    } catch (PDOException $e) {
        throw new Exception("Error counting movies: " . $e->getMessage());
    }
}

