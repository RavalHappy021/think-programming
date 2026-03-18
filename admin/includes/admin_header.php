<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check: Ensure only admins can access this area
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Think Programming</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <!-- Main Style CSS for common variables -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="index.php" class="logo">
                <i class="fas fa-cube"></i>
                <span>Think</span>Admin
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="users.php" class="<?= $current_page == 'users.php' ? 'active' : '' ?>">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a href="categories.php" class="<?= $current_page == 'categories.php' ? 'active' : '' ?>">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="tutorials.php" class="<?= $current_page == 'tutorials.php' ? 'active' : '' ?>">
                        <i class="fas fa-book"></i> Tutorials
                    </a>
                </li>
                <li>
                    <a href="practice.php" class="<?= $current_page == 'practice.php' ? 'active' : '' ?>">
                        <i class="fas fa-laptop-code"></i> Practice
                    </a>
                </li>
                <li>
                    <a href="examples.php" class="<?= $current_page == 'examples.php' ? 'active' : '' ?>">
                        <i class="fas fa-code"></i> Examples
                    </a>
                </li>
                <li class="nav-divider"></li>
                <li>
                    <a href="../index.php">
                        <i class="fas fa-external-link-alt"></i> View Site
                    </a>
                </li>
                <li>
                    <a href="../logout.php" style="color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-topbar">
            <h2><?= ucfirst(str_replace('.php', '', $current_page == 'index.php' ? 'Dashboard' : $current_page)) ?></h2>
            <div class="user-info">
                <span>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                <i class="fas fa-user-shield"></i>
            </div>
        </header>
        <div class="admin-content">
