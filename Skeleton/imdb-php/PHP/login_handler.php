<?php
session_start();

// Replace with your actual DB logic
$validEmail = 'test@example.com';
$validPassword = 'password123'; // In real life, use hashed passwords and verify with password_verify()

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === $validEmail && $password === $validPassword) {
    $_SESSION['user'] = ['email' => $email];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
}


