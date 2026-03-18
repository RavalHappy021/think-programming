<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch categories
$stmtCats = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmtCats->fetchAll(PDO::FETCH_ASSOC);

$selected_cat = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch tutorials based on category
if ($selected_cat) {
    $stmt = $pdo->prepare("SELECT t.*, c.name as cat_name FROM tutorials t JOIN categories c ON t.category_id = c.id WHERE c.slug = ? ORDER BY t.created_at DESC");
    $stmt->execute([$selected_cat]);
} else {
    $stmt = $pdo->query("SELECT t.*, c.name as cat_name FROM tutorials t JOIN categories c ON t.category_id = c.id ORDER BY t.created_at DESC");
}
$tutorials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="section-title">Programming Tutorials</h1>
    
    <!-- Category Filter -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; justify-content: center;">
        <a href="tutorials.php" class="<?= $selected_cat == '' ? 'btn-primary' : 'btn-outline' ?>">All</a>
        <?php foreach($categories as $cat): ?>
            <a href="tutorials.php?category=<?= $cat['slug'] ?>" class="<?= $selected_cat == $cat['slug'] ? 'btn-primary' : 'btn-outline' ?>">
                <i class="<?= htmlspecialchars($cat['icon']) ?>"></i> <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Tutorials List -->
    <div class="card-grid">
        <?php if(count($tutorials) > 0): ?>
            <?php foreach($tutorials as $tut): ?>
                <div class="card" style="text-align: left;">
                    <span style="background: var(--glass-border); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; color: var(--accent); margin-bottom: 1rem; display: inline-block;">
                        <?= htmlspecialchars($tut['cat_name']) ?>
                    </span>
                    <h3 class="card-title"><?= htmlspecialchars($tut['title']) ?></h3>
                    <div class="card-text" style="max-height: 100px; overflow: hidden; position: relative;">
                        <?= strip_tags($tut['content'], '<p><b><i>') ?>
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 40px; background: linear-gradient(transparent, var(--glass-bg));"></div>
                    </div>
                    <a href="tutorial_view.php?id=<?= $tut['id'] ?>" class="btn-outline" style="margin-top: 1rem; width: 100%; text-align: center;">Read More</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%; color: var(--text-muted);">No tutorials found for this category yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
