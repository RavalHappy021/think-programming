<?php
// Secure session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect them away if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'includes/header.php';
?>

<div class="container" style="padding-top: 4rem;">
    <div style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%); border-radius: 20px; padding: 3rem; text-align: center; border: 1px solid var(--border); margin-bottom: 3rem;">
        <h1 class="section-title" style="margin-bottom: 1rem;">Welcome to your Dashboard, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">This is your personal space where you can track your learning progress and access your saved practice modules.</p>
    </div>

    <h2 class="section-title" style="text-align: left; font-size: 1.8rem;">Quick Links</h2>
    <div class="card-grid">
        <div class="card">
            <i class="fas fa-book-open card-icon"></i>
            <h3 class="card-title">Continue Learning</h3>
            <p class="card-text">Jump back into the tutorials and pick up where you left off.</p>
            <a href="tutorials.php" class="btn-primary">Browse Tutorials</a>
        </div>
        <div class="card">
            <i class="fas fa-laptop-code card-icon"></i>
            <h3 class="card-title">Practice Area</h3>
            <p class="card-text">Sharpen your coding skills with new challenges today.</p>
            <a href="practice.php" class="btn-outline">Go to Practice</a>
        </div>
        <div class="card">
            <i class="fas fa-cog card-icon" style="color: var(--text-muted); background: var(--border);"></i>
            <h3 class="card-title">Account Settings</h3>
            <p class="card-text">Manage your profile, email preferences, and password.</p>
            <button class="btn-outline" style="border-color: var(--border); color: var(--text-muted); cursor: not-allowed;" disabled>Coming Soon</button>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
