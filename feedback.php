<?php
require_once 'includes/db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$msg = '';
$msgClass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $rating = (int) $_POST['rating'];
    $comments = trim($_POST['comments']);

    if (empty($name) || empty($email) || empty($comments) || !$rating) {
        $msg = 'Please complete all required fields and select a rating.';
        $msgClass = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO feedback (user_id, name, email, rating, comments) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $name, $email, $rating, $comments])) {
                $msg = 'Thank you! Your feedback helps us improve.';
                $msgClass = 'success';
            } else {
                $msg = 'Something went wrong. Please try again.';
                $msgClass = 'error';
            }
        } catch(PDOException $e) {
            $msg = 'Database error. Please try again.';
            $msgClass = 'error';
        }
    }
}
include 'includes/header.php';
?>

<div class="container" style="max-width: 600px; padding: 4rem 2rem;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 class="section-title" style="margin-bottom: 0.5rem;">User Feedback</h1>
        <p style="color: var(--text-muted);">We'd love to hear your thoughts on the Think Programming platform.</p>
    </div>

    <?php if($msg): ?>
        <div style="background: <?= $msgClass == 'success' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; 
                    border: 1px solid <?= $msgClass == 'success' ? '#10b981' : '#ef4444' ?>; 
                    color: <?= $msgClass == 'success' ? '#10b981' : '#ef4444' ?>; 
                    padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <div class="card" style="text-align: left;">
        <form method="POST" action="">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Platform Rating (1-5)</label>
                <select name="rating" class="form-control" required style="cursor: pointer; appearance: auto;">
                    <option value="">Select a rating</option>
                    <option value="5">5 - Excellent (Love it!)</option>
                    <option value="4">4 - Very Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Needs Major Improvement</option>
                </select>
            </div>
            <div class="form-group">
                <label>Your Feedback</label>
                <textarea name="comments" class="form-control" rows="5" required placeholder="What do you think we can improve?"></textarea>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem; padding: 1rem;">Submit Feedback</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
