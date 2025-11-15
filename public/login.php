<?php
require_once '../config/db.php';
require_once 'partials/header.php';

// If user is already logged in, redirect to dashboard
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Email and password are required.';
    } else {
        try {
            // Find user by email
            $stmt = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Verify password
            if ($user && password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                
                // Redirect to the dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            error_log('Login Error: ' . $e->getMessage());
            $error = 'An error occurred during login. Please try again.';
        }
    }
}
?>

<div class="form-container">
    <form action="login.php" method="POST" class="auth-form">
        <h2>Welcome Back!</h2>
        <p>Log in to manage your credit cards and finances.</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Log In</button>
        </div>
        <div class="form-footer">
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
