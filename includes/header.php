<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Get current page name to highlight nav link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Think Programming - Learn to Code</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Mobile Menu JS -->
    <script src="assets/js/mobile-menu.js" defer></script>
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="logo">
        <i class="fas fa-cube"></i>
        <span>Think</span>Programming
    </a>
    <ul class="nav-links">
        <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="tutorials.php" class="<?= $current_page == 'tutorials.php' ? 'active' : '' ?>">Tutorials</a></li>
        <li><a href="practice.php" class="<?= $current_page == 'practice.php' ? 'active' : '' ?>">Practice</a></li>
        <li><a href="examples.php" class="<?= $current_page == 'examples.php' ? 'active' : '' ?>">Examples</a></li>
        <li><a href="contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Contact</a></li>
        <li><a href="feedback.php" class="<?= $current_page == 'feedback.php' ? 'active' : '' ?>">Feedback</a></li>
    </ul>
    <div class="nav-actions">
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn-outline">Dashboard</a>
            <a href="logout.php" class="btn-primary">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-outline">Login</a>
            <a href="register.php" class="btn-primary" id="signup-btn">Sign Up</a>
        <?php endif; ?>
    </div>
    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</nav>
<div class="mobile-overlay" id="mobile-overlay"></div>

<main>
