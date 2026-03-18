<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch categories
$stmtCats = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmtCats->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="section-title">Practice Modules</h1>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 3rem;">Select a language to start practicing your skills with interactive challenges.</p>

    <div class="card-grid">
        <?php foreach($categories as $cat): ?>
            <div class="card">
                <i class="<?= htmlspecialchars($cat['icon']) ?> card-icon"></i>
                <h3 class="card-title"><?= htmlspecialchars($cat['name']) ?> Challenges</h3>
                <p class="card-text">Test your <?= htmlspecialchars($cat['name']) ?> knowledge with hand-crafted exercises.</p>
                <a href="practice.php?category=<?= $cat['slug'] ?>" class="btn-primary" onclick="alert('Module loading... (This is a generic UI outline for practicing)')">Start Practicing</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
