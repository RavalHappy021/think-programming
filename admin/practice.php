<?php
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/includes/admin_header.php';

$msg = ''; $type = '';

// Handle Create/Update
if (isset($_POST['save_practice'])) {
    $id = $_POST['id'];
    $cat_id = $_POST['category_id'];
    $title = $_POST['title'];
    $question = $_POST['question'];
    $expected_output = $_POST['expected_output'];
    $difficulty = $_POST['difficulty'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE practice_modules SET category_id=?, title=?, question=?, expected_output=?, difficulty=? WHERE id=?");
        $stmt->execute([$cat_id, $title, $question, $expected_output, $difficulty, $id]);
        $msg = "Practice module updated!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO practice_modules (category_id, title, question, expected_output, difficulty) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$cat_id, $title, $question, $expected_output, $difficulty]);
        $msg = "Practice module created!";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM practice_modules WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $msg = "Practice module deleted!";
}

// Handle Edit Fetch
$edit_prac = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM practice_modules WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_prac = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch lists
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$practice = $pdo->query("SELECT p.*, c.name as cat_name FROM practice_modules p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if($msg): ?>
    <div style="padding: 1rem; border-radius: 8px; margin-bottom: 2rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid #10b981;">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<!-- Form Section -->
<div class="admin-card" style="margin-bottom: 3rem;">
    <div class="admin-card-header">
        <h3 style="margin: 0;"><?= $edit_prac ? 'Edit Module' : 'Add Practice Module' ?></h3>
    </div>
    <form method="POST" action="practice.php" style="padding: 2rem;">
        <input type="hidden" name="id" value="<?= $edit_prac['id'] ?? '' ?>">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($edit_prac) && $edit_prac['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Title</label>
                <input type="text" name="title" class="form-control" required value="<?= $edit_prac['title'] ?? '' ?>">
            </div>
            <div class="admin-form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Difficulty</label>
                <select name="difficulty" class="form-control">
                    <option value="Beginner" <?= (isset($edit_prac) && $edit_prac['difficulty'] == 'Beginner') ? 'selected' : '' ?>>Beginner</option>
                    <option value="Intermediate" <?= (isset($edit_prac) && $edit_prac['difficulty'] == 'Intermediate') ? 'selected' : '' ?>>Intermediate</option>
                    <option value="Advanced" <?= (isset($edit_prac) && $edit_prac['difficulty'] == 'Advanced') ? 'selected' : '' ?>>Advanced</option>
                </select>
            </div>
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Question / Instructions</label>
            <textarea name="question" class="form-control" rows="4" required><?= $edit_prac['question'] ?? '' ?></textarea>
        </div>

        <div class="admin-form-group">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Expected Output</label>
            <input type="text" name="expected_output" class="form-control" value="<?= $edit_prac['expected_output'] ?? '' ?>">
        </div>

        <button type="submit" name="save_practice" class="btn-primary" style="width: 100%;">Save Module</button>
    </form>
</div>

<!-- List Section -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 style="margin: 0;">Existing Challenges</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Difficulty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($practice as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['cat_name']) ?></strong></td>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><span class="badge badge-user"><?= $p['difficulty'] ?></span></td>
                    <td style="display: flex; gap: 1rem;">
                        <a href="practice.php?edit=<?= $p['id'] ?>" style="color: var(--primary);"><i class="fas fa-edit"></i></a>
                        <a href="practice.php?delete=<?= $p['id'] ?>" onclick="return confirm('Delete this challenge?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
