-- Remove existing users table if it has email
DROP TABLE IF EXISTS users;

-- Create new table with username column
CREATE TABLE users (
                       id INTEGER PRIMARY KEY AUTOINCREMENT,
                       username TEXT UNIQUE NOT NULL,
                       password_hash TEXT NOT NULL,
                       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);