<?php
require_once '../config/db.php';
require_once 'partials/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Name, email, and password are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                $error = 'Email address is already registered.';
            } else {
                // Hash the password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $insert_stmt = $pdo->prepare(
                    'INSERT INTO users (name, email, password_hash, phone) VALUES (:name, :email, :password_hash, :phone)'
                );
                $insert_stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password_hash' => $password_hash,
                    'phone' => $phone ?: null
                ]);

                $success = 'Registration successful! You can now <a href="login.php">log in</a>.';
            }
        } catch (PDOException $e) {
            error_log('Registration Error: ' . $e->getMessage());
            $error = 'An error occurred during registration. Please try again.';
        }
    }
}
?>

<div class="brand-header">
    <h1 class="brand-title">CredX</h1>
</div>

<div class="form-container">
    <form action="register.php" method="POST" class="auth-form">
        <h2>Create Your Account</h2>
        <p>Join the #1 platform for managing your credit cards.</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number (Optional)</label>
            <input type="tel" id="phone" name="phone">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
        <div class="form-footer">
            <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
