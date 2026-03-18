<?php
require_once 'includes/db.php';
$msg = '';
$msgClass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $msg = 'Please fill in all required fields.';
        $msgClass = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $subject, $message])) {
                $msg = 'Thank you! Your message has been sent successfully. We will get back to you soon.';
                $msgClass = 'success';
            } else {
                $msg = 'Something went wrong. Please try again later.';
                $msgClass = 'error';
            }
        } catch (PDOException $e) {
            $msg = 'Database error. Please try again later.';
            $msgClass = 'error';
        }
    }
}
include 'includes/header.php';
?>

<div class="container" style="max-width: 600px; padding: 4rem 2rem;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 class="section-title" style="margin-bottom: 0.5rem;">Contact Us</h1>
        <p style="color: var(--text-muted);">Have questions or need support? Reach out to our team.</p>
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
                <label>Full Name <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label>Email Address <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" class="form-control" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="What is this regarding?">
            </div>
            <div class="form-group">
                <label>Message <span style="color: #ef4444;">*</span></label>
                <textarea name="message" class="form-control" rows="5" required placeholder="Write your message here..."></textarea>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem; padding: 1rem;">Send Message</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
