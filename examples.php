<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Generate dummy data if table is empty for demonstration
$checkStmt = $pdo->query("SELECT COUNT(*) FROM examples");
if($checkStmt->fetchColumn() == 0) {
    try {
        $pdo->exec("INSERT INTO examples (category_id, title, code_snippet, explanation) VALUES 
        (1, 'Hello World in Python', 'print(\"Hello, World!\")', 'The simplest program in Python.'),
        (2, 'DOM Manipulation', 'document.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";', 'Changing HTML content with JS.'),
        (3, 'Simple DB Connect', '\$conn = new mysqli(\$host, \$user, \$pass, \$db);', 'MySQL connection using MySQLi in PHP.')");
    } catch(Exception $e) {}
}

$stmt = $pdo->query("SELECT e.*, c.name as cat_name FROM examples e JOIN categories c ON e.category_id = c.id ORDER BY e.id DESC");
$examples = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="section-title">Code Examples</h1>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 3rem;">Real-world snippets to speed up your development.</p>

    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 800px; margin: 0 auto;">
        <?php foreach($examples as $ex): ?>
            <div class="card" style="text-align: left; width: 100%;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="card-title" style="margin: 0;"><?= htmlspecialchars($ex['title']) ?></h3>
                    <span style="background: var(--primary); color: #fff; padding: 0.2rem 0.6rem; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">
                        <?= htmlspecialchars($ex['cat_name']) ?>
                    </span>
                </div>
                <div style="background: var(--darker); padding: 1.5rem; border-radius: 10px; overflow-x: auto; border: 1px solid var(--glass-border); margin-bottom: 1rem;">
                    <code style="color: #a5b4fc; font-family: 'Courier New', Courier, monospace; display: block;">
                        <?= nl2br(htmlspecialchars($ex['code_snippet'])) ?>
                    </code>
                </div>
                <p class="card-text" style="margin-bottom: 0;">
                    <i class="fas fa-info-circle" style="color: var(--accent); margin-right: 0.5rem;"></i>
                    <?= htmlspecialchars($ex['explanation']) ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
