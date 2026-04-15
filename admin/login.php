<?php
/**
 * admin/login.php
 * Secure login page for event administrators
 */
session_start();
require_once '../db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Simple check as per requirements (admin/admin)
            // Note: In real production, use password_verify() with hashed passwords
            if ($user && $password === $user['password']) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $error = "An error occurred. Please try again later.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SVU Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; }
        .login-card { width: 100%; max-width: 400px; margin: auto; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <h2 class="h3 fw-normal">Admin Control Panel</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-3">
        <a href="../index.php" class="text-decoration-none small text-muted">&larr; Back to Website</a>
    </div>
</div>

</body>
</html>
