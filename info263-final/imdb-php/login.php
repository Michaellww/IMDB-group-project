<?php
session_start();
require __DIR__ . '/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $user = authenticateUser($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $redirectUrl = $_GET['redirect'] ?? 'index.php';
            header("Location: $redirectUrl");
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Log In - IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .password-tips li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .password-tips li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="auth-container">
    <h2 class="mb-4">Log in</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger mb-3"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="mt-1">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#passwordHelpModal">
                    Password assistance
                </a>
            </div>
        </div>

        <button type="submit" class="btn btn-warning w-100">Log in</button>

        <div class="mt-4 text-center">
            <hr>
            <span class="text-muted">New to IMDB?</span>
            <a href="register.php" class="btn btn-link">Create your account</a>
        </div>
    </form>
</div>

<!-- Password Help Modal -->
<div class="modal fade" id="passwordHelpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Requirements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Create strong passwords:</h6>
                <ul class="password-tips list-unstyled">
                    <li>Minimum 8 characters</li>
                    <li>At least one uppercase letter</li>
                    <li>At least one lowercase letter</li>
                    <li>At least one number</li>
                    <li>At least one special character (!@#$%^&*)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>