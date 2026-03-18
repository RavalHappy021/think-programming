<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/includes/admin_header.php';

$msg = ''; $type = '';

// Handle Create/Update
if (isset($_POST['save_tutorial'])) {
    $id = $_POST['id'];
    $cat_id = $_POST['category_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $video_url = $_POST['video_url'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE tutorials SET category_id=?, title=?, content=?, video_url=? WHERE id=?");
        $stmt->execute([$cat_id, $title, $content, $video_url, $id]);
        $msg = "Tutorial updated successfully!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tutorials (category_id, title, content, video_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$cat_id, $title, $content, $video_url]);
        $msg = "Tutorial created successfully!";
    }
    $type = "success";
}

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM tutorials WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $msg = "Tutorial deleted successfully!";
}

// Handle Edit Fetch
$edit_tut = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM tutorials WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_tut = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch lists
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$tutorials = $pdo->query("SELECT t.*, c.name as cat_name FROM tutorials t JOIN categories c ON t.category_id = c.id ORDER BY t.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if($msg): ?>
    <div style="padding: 1rem; border-radius: 8px; margin-bottom: 2rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid #10b981;">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<!-- Form Section -->
<div class="admin-card" style="margin-bottom: 3rem;">
    <div class="admin-card-header">
        <h3 style="margin: 0;"><?= $edit_tut ? 'Edit Tutorial' : 'Create New Tutorial' ?></h3>
    </div>
    <form method="POST" action="tutorials.php" style="padding: 2rem;">
        <input type="hidden" name="id" value="<?= $edit_tut['id'] ?? '' ?>">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($edit_tut) && $edit_tut['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tutorial Title</label>
                <input type="text" name="title" class="form-control" required value="<?= $edit_tut['title'] ?? '' ?>" placeholder="e.g. Loops in Python">
            </div>
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Video URL (Optional)</label>
            <input type="url" name="video_url" class="form-control" value="<?= $edit_tut['video_url'] ?? '' ?>" placeholder="https://youtube.com/...">
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Content (HTML Supported)</label>
            <textarea name="content" class="form-control" rows="8" required placeholder="Tutorial body..."><?= $edit_tut['content'] ?? '' ?></textarea>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" name="save_tutorial" class="btn-primary" style="flex: 2;">Save Tutorial Content</button>
            <?php if($edit_tut): ?>
                <a href="tutorials.php" class="btn-outline" style="flex: 1; text-align: center; text-decoration: none;">Discard Changes</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- List Section -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 style="margin: 0;">All Tutorials</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tutorials as $tut): ?>
                <tr>
                    <td>#<?= $tut['id'] ?></td>
                    <td><span class="badge badge-user"><?= htmlspecialchars($tut['cat_name']) ?></span></td>
                    <td><strong><?= htmlspecialchars($tut['title']) ?></strong></td>
                    <td><?= date('M d, Y', strtotime($tut['created_at'])) ?></td>
                    <td style="display: flex; gap: 1rem;">
                        <a href="tutorials.php?edit=<?= $tut['id'] ?>" style="color: var(--primary);"><i class="fas fa-edit"></i> Edit</a>
                        <a href="tutorials.php?delete=<?= $tut['id'] ?>" onclick="return confirm('Delete this tutorial?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
