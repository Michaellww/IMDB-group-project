<?php
session_start();
session_unset();
session_destroy();

$redirectUrl = $_GET['redirect'] ?? 'login.php';  // Default if not provided
header("Location: $redirectUrl");
exit;
