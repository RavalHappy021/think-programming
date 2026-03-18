<?php
require_once 'includes/db.php';

echo "<h2>Admin Setup Utility</h2>";

try {
    // 1. Add role column if it doesn't exist
    $chk = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($chk->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user' AFTER password");
        echo "<p style='color: green;'>Added 'role' column to users table.</p>";
    } else {
        echo "<p>Column 'role' already exists.</p>";
    }

    // 2. Promote current user to admin if logged in, or ask for username
    if (isset($_GET['promote'])) {
        $userToPromote = $_GET['promote'];
        $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
        $stmt->execute([$userToPromote]);
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>User '<strong>$userToPromote</strong>' has been promoted to Admin!</p>";
        } else {
            echo "<p style='color: red;'>User '<strong>$userToPromote</strong>' not found.</p>";
        }
    } else {
        echo "<p>To promote a user, visit: <code>admin_setup.php?promote=YOUR_USERNAME</code></p>";
    }

    echo "<p><a href='index.php'>Go to Home</a></p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
