<?php
require_once '../includes/db.php';
include 'includes/admin_header.php';

$msg = ''; $type = '';

// Handle Create/Update
if (isset($_POST['save_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $icon = $_POST['icon'];
    $description = $_POST['description'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE categories SET name=?, slug=?, icon=?, description=? WHERE id=?");
        $stmt->execute([$name, $slug, $icon, $description, $id]);
        $msg = "Category updated successfully!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, icon, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $slug, $icon, $description]);
        $msg = "Category created successfully!";
    }
    $type = "success";
}

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $msg = "Category deleted successfully!";
    $type = "success";
}

// Handle Edit Fetch
$edit_cat = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_cat = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if($msg): ?>
    <div style="padding: 1rem; border-radius: 8px; margin-bottom: 2rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid #10b981;">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Form Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="margin: 0;"><?= $edit_cat ? 'Edit Category' : 'Add New Category' ?></h3>
        </div>
        <form method="POST" action="categories.php" style="padding: 1.5rem;">
            <input type="hidden" name="id" value="<?= $edit_cat['id'] ?? '' ?>">
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Name</label>
                <input type="text" name="name" class="form-control" required value="<?= $edit_cat['name'] ?? '' ?>" placeholder="e.g. Python">
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Slug</label>
                <input type="text" name="slug" class="form-control" required value="<?= $edit_cat['slug'] ?? '' ?>" placeholder="e.g. python">
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Icon (FontAwesome class)</label>
                <input type="text" name="icon" class="form-control" required value="<?= $edit_cat['icon'] ?? 'fas fa-code' ?>" placeholder="fab fa-python">
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief overview..."><?= $edit_cat['description'] ?? '' ?></textarea>
            </div>
            <button type="submit" name="save_category" class="btn-primary" style="width: 100%;">Save Category</button>
            <?php if($edit_cat): ?>
                <a href="categories.php" class="btn-outline" style="width: 100%; margin-top: 1rem; text-align: center; text-decoration: none;">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- List Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 style="margin: 0;">Existing Categories</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $cat): ?>
                    <tr>
                        <td><i class="<?= $cat['icon'] ?>"></i></td>
                        <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                        <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                        <td style="display: flex; gap: 0.5rem;">
                            <a href="categories.php?edit=<?= $cat['id'] ?>" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                            <a href="categories.php?delete=<?= $cat['id'] ?>" onclick="return confirm('Deleting a category will delete all tutorials within it. Continue?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
