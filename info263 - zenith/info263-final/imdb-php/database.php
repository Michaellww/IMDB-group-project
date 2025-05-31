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
        throw new Exception("Error fetching titles: " . $e->getMessage());
    }
}

function getPeople($offset = 0, $limit = 24) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("SELECT * FROM name_basics_trim LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw new Exception("Error fetching people: " . $e->getMessage());
    }
}

function getTitleCount($type = null, $startsWith = null, $year = null, $rating = null, $runtime = null) {
    $pdo = getPDO();
    $sql = "SELECT COUNT(*) FROM title_basics_trim t
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

    try {
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        throw new Exception("Error counting titles: " . $e->getMessage());
    }
}

function getAllGenres() {
    $pdo = getPDO();
    try {
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

        return array_unique($allGenres);
    } catch (PDOException $e) {
        throw new Exception("Error fetching genres: " . $e->getMessage());
    }
}

function registerUser($username, $email, $password) {
    $pdo = getPDO();

    if (strlen($password) < 8) {
        throw new Exception("Password must be at least 8 characters");
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        throw new Exception("Username or email already exists");
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hash]);

    return $pdo->lastInsertId();
}

function authenticateUser($email, $password) {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password_hash)) {
            return $user;
        }
        return false;
    } catch (PDOException $e) {
        throw new Exception("Authentication error: " . $e->getMessage());
    }
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
        throw new Exception("Error fetching genre movies: " . $e->getMessage());
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
        throw new Exception("Error counting genre movies: " . $e->getMessage());
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
        throw new Exception("Error fetching top rated movies: " . $e->getMessage());
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

// ✅ Movie detail fetch
function getTitle($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT t.*, r.averageRating AS rating, r.numVotes
        FROM title_basics_trim t
        LEFT JOIN title_ratings_trim r ON t.tconst = r.tconst
        WHERE t.tconst = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// ✅ Movie cast fetch
function getTitleCast($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT n.primaryName, tp.category, tp.job, tp.characters
        FROM title_principals_trim tp
        JOIN name_basics_trim n ON tp.nconst = n.nconst
        WHERE tp.tconst = ?
        ORDER BY tp.ordering ASC
        LIMIT 12
    ");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>
