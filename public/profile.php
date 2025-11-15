<?php
require_once '../config/db.php';
protect_page();

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($name) || empty($email)) {
        $error = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            // Check if email is being changed and if the new one is already taken
            $stmt = $pdo->prepare('SELECT id, email FROM users WHERE id = :id');
            $stmt->execute(['id' => $user_id]);
            $currentUser = $stmt->fetch();

            if (strtolower($email) !== strtolower($currentUser['email'])) {
                $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
                $stmt->execute(['email' => $email]);
                if ($stmt->fetch()) {
                    $error = 'That email address is already in use.';
                }
            }

            if (!$error) {
                // Update basic info
                $update_sql = 'UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id';
                $params = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone ?: null,
                    'id' => $user_id,
                ];
                $stmt = $pdo->prepare($update_sql);
                $stmt->execute($params);

                // Update password if provided and matches confirmation
                if (!empty($password)) {
                    if ($password !== $password_confirm) {
                        $error = 'Passwords do not match.';
                    } else {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare('UPDATE users SET password_hash = :password_hash WHERE id = :id');
                        $stmt->execute(['password_hash' => $password_hash, 'id' => $user_id]);
                    }
                }
                
                if (!$error) {
                    $success = 'Profile updated successfully!';
                    // Update session name if it was changed
                    $_SESSION['user_name'] = $name;
                }
            }
        } catch (PDOException $e) {
            error_log('Profile Update Error: ' . $e->getMessage());
            $error = 'An error occurred while updating your profile.';
        }
    }
}

// Fetch current user data to pre-fill the form
try {
    $stmt = $pdo->prepare('SELECT name, email, phone FROM users WHERE id = :id');
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    error_log('Profile Fetch Error: ' . $e->getMessage());
    $error = 'Could not retrieve your profile data.';
    $user = ['name' => '', 'email' => '', 'phone' => '']; // Default empty values
}

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="page-header">
    <h1>My Profile</h1>
    <p>Update your personal information and password.</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="form-box">
    <h3>Edit Your Information</h3>
    <form action="profile.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone Number (Optional)</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
            </div>
        </div>
        
        <hr>
        
        <h4>Change Password (Optional)</h4>
        <p>Leave blank to keep your current password.</p>
        <div class="form-row">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm New Password</label>
                <input type="password" id="password_confirm" name="password_confirm">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
