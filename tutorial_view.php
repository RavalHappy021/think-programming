<?php 
require_once 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: tutorials.php");
    exit;
}

$stmt = $pdo->prepare("SELECT t.*, c.name as cat_name, c.icon as cat_icon FROM tutorials t JOIN categories c ON t.category_id = c.id WHERE t.id = ?");
$stmt->execute([$_GET['id']]);
$tutorial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tutorial) {
    header("Location: tutorials.php");
    exit;
}

include 'includes/header.php'; 
?>

<div class="container" style="max-width: 800px; padding-top: 4rem;">
    <a href="tutorials.php" class="btn-outline" style="margin-bottom: 2rem; padding: 0.5rem 1rem;"><i class="fas fa-arrow-left"></i> Back to Tutorials</a>
    
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <i class="<?= htmlspecialchars($tutorial['cat_icon']) ?>" style="font-size: 2rem; color: var(--primary);"></i>
        <span style="background: var(--glass-border); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.9rem; color: var(--text-muted);">
            <?= htmlspecialchars($tutorial['cat_name']) ?>
        </span>
    </div>
    
    <h1 class="section-title" style="text-align: left; margin-bottom: 0.5rem;"><?= htmlspecialchars($tutorial['title']) ?></h1>
    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9rem;">
        Published on <?= date('F j, ', strtotime($tutorial['created_at'])) . '2022' ?>
    </p>

    <div class="card" style="text-align: left; padding: 3rem; line-height: 1.8; font-size: 1.1rem; color: #e2e8f0;">
        <?= html_entity_decode($tutorial['content']) ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
