<?php
try {
    // Connect to the SQLite database using relative path
    $db = new PDO("sqlite:imdb.2.sqlite3");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user TEXT NOT NULL,
        password TEXT NOT NULL
    )");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form input and trim whitespace
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
            exit();
        }

        // Insert the new account into the database
        $stmt = $db->prepare("INSERT INTO users (user, password) VALUES (:user, :password)");
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {

            header("Location: login.html");
            exit();
        } else {
            echo "Failed to create account.";
        }
    } else {
        echo "Please submit the form.";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

