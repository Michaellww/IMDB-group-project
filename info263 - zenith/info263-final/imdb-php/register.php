<?php
session_start();
require __DIR__ . '/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    try {
        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception('All fields are required');
        }

        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }

        registerUser($name, $email, $password);
        $_SESSION['success'] = 'Registration successful! Please login';
        header('Location: login.php');
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Account - IMDB</title>
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
        .progress-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/navigation.php'; ?>

<div class="auth-container">
    <h2 class="mb-4">Create your IMDB account</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger mb-3"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="password-strength mt-2">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Password strength: <span id="strengthText">Weak</span></small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Re-enter password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning w-100">Create account</button>

        <div class="mt-4 text-center">
            <hr>
            <span class="text-muted">Already have an account?</span>
            <a href="login.php" class="btn btn-link">Log in</a>
        </div>
    </form>
</div>

<script>
    // Password Strength Meter
    document.querySelector('input[name="password"]').addEventListener('input', function(e) {
        const password = e.target.value;
        const progress = document.querySelector('.progress-bar');
        const strengthText = document.querySelector('#strengthText');

        let strength = 0;

        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;

        // Character checks
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        const width = Math.min((strength/5) * 100, 100);
        progress.style.width = width + '%';

        // Update display
        if (strength < 2) {
            progress.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Weak';
        } else if (strength < 4) {
            progress.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Medium';
        } else {
            progress.className = 'progress-bar bg-success';
            strengthText.textContent = 'Strong';
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>