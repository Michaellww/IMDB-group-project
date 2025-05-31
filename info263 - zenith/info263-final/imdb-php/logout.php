<?php
session_start();
session_unset(); // Clear session content
session_destroy(); // Destroy the session
header("Location: index.php");
exit;
