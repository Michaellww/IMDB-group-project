<?php
require_once 'connection.php';

try {
    $pdo = getPDO();

    $sql = "
    CREATE TABLE IF NOT EXISTS wishlist (
        user_id INTEGER NOT NULL,
        tconst TEXT NOT NULL,
        PRIMARY KEY (user_id, tconst)
    );
    ";

    $pdo->exec($sql);
    echo "✅ Wishlist table created successfully.";
} catch (PDOException $e) {
    echo "❌ Error creating wishlist table: " . $e->getMessage();
}
