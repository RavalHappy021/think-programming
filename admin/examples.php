<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/includes/admin_header.php';

$msg = '';

// Handle Create/Update
if (isset($_POST['save_example'])) {
    $id = $_POST['id'];
    $cat_id = $_POST['category_id'];
    $title = $_POST['title'];
    $code = $_POST['code_snippet'];
    $explanation = $_POST['explanation'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE examples SET category_id=?, title=?, code_snippet=?, explanation=? WHERE id=?");
        $stmt->execute([$cat_id, $title, $code, $explanation, $id]);
        $msg = "Example updated successfully!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO examples (category_id, title, code_snippet, explanation) VALUES (?, ?, ?, ?)");
        $stmt->execute([$cat_id, $title, $code, $explanation]);
        $msg = "Example added successfully!";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM examples WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $msg = "Example removed.";
}

// Handle Edit Fetch
$edit_ex = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM examples WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_ex = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch lists
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$examples = $pdo->query("SELECT e.*, c.name as cat_name FROM examples e JOIN categories c ON e.category_id = c.id ORDER BY e.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if($msg): ?>
    <div style="padding: 1rem; border-radius: 8px; margin-bottom: 2rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid #10b981;">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<div class="admin-card" style="margin-bottom: 3rem;">
    <div class="admin-card-header">
        <h3 style="margin: 0;"><?= $edit_ex ? 'Edit Example' : 'Add Code Example' ?></h3>
    </div>
    <form method="POST" action="examples.php" style="padding: 2rem;">
        <input type="hidden" name="id" value="<?= $edit_ex['id'] ?? '' ?>">
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($edit_ex) && $edit_ex['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Example Title</label>
                <input type="text" name="title" class="form-control" required value="<?= $edit_ex['title'] ?? '' ?>" placeholder="e.g. Binary Search implementation">
            </div>
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Code Snippet</label>
            <textarea name="code_snippet" class="form-control" rows="10" required style="font-family: 'Courier New', monospace; background: #2d3436; color: #fff;"><?= $edit_ex['code_snippet'] ?? '' ?></textarea>
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Explanation</label>
            <textarea name="explanation" class="form-control" rows="4"><?= $edit_ex['explanation'] ?? '' ?></textarea>
        </div>

        <button type="submit" name="save_example" class="btn-primary" style="width: 100%;">Save Example</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 style="margin: 0;">Code Library</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Language</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($examples as $ex): ?>
                <tr>
                    <td><span class="badge badge-admin"><?= htmlspecialchars($ex['cat_name']) ?></span></td>
                    <td><strong><?= htmlspecialchars($ex['title']) ?></strong></td>
                    <td style="display: flex; gap: 1rem;">
                        <a href="examples.php?edit=<?= $ex['id'] ?>" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <a href="examples.php?delete=<?= $ex['id'] ?>" onclick="return confirm('Delete this example?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
