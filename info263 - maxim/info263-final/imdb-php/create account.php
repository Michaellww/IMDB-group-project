<?php
try {
    // Connect to SQLite database
    $db = new PDO("sqlite:imdb.2.sqlite3");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Search for the username in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE user = :user");
    $stmt->bindParam(':user', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Username found, now check password
        if ($user['password'] === $password) {
            // Login success
            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect
            header("Location: error.html");
            exit();
        }
    } else {
        // Username not found
        header("Location: create-account.html");
        exit();
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
