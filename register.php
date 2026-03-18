<?php
require_once 'includes/db.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'Username or email already exists.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                $success = 'Registration successful! You can now <a href="login.php">login</a>.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="container" style="padding: 4rem 2rem; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="auth-container" style="width: 100%;">
        <h2 class="section-title" style="margin-bottom: 2rem; text-align: center; font-size: 2rem;">Create Account</h2>
        
        <?php if($error): ?>
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if($success): ?>
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                <?= $success ?>
            </div>
        <?php else: ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required placeholder="johndoe">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required placeholder="********">
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem; padding: 1rem;">Sign Up</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
            Already have an account? <a href="login.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">Log in</a>
        </p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
