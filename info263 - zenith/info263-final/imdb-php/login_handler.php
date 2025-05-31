<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

try {
    $db = new PDO("sqlite:imdb.2.sqlite3");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? "");

        if ($username === '' || $password === '') {
            $error = "Missing username or password.";
        } else {
            $stmt = $db->prepare("SELECT * FROM users WHERE user = :username AND password = :password");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["user"];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        }
    } else {
        $error = "Please submit the form.";
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<!-- Show error page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Failed - IMDB 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .error-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h2 class="text-danger">Login Failed</h2>
    <p><?= htmlspecialchars($error ?? "Unknown error.") ?></p>
    <a href="login.php" class="btn btn-warning mt-3">⬅️ Back to Login</a>
</div>
</body>
</html>
