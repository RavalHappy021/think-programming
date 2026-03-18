<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/includes/admin_header.php';

// Fetch Statistics
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$tutorialCount = $pdo->query("SELECT COUNT(*) FROM tutorials")->fetchColumn();
$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$exampleCount = $pdo->query("SELECT COUNT(*) FROM examples")->fetchColumn();
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: var(--primary);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>Total Users</h3>
            <p><?= $userCount ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent);">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <h3>Tutorials</h3>
            <p><?= $tutorialCount ?></p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1); color: var(--secondary);">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-info">
            <h3>Categories</h3>
            <p><?= $categoryCount ?></p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
            <i class="fas fa-code"></i>
        </div>
        <div class="stat-info">
            <h3>Examples</h3>
            <p><?= $exampleCount ?></p>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 style="margin: 0;">Recent Activity</h3>
        <span style="font-size: 0.8rem; color: var(--text-muted);">Overview of platform growth</span>
    </div>
    <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
        <i class="fas fa-history" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.2;"></i>
        <p>Activity logging will be implemented in a future update.</p>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
