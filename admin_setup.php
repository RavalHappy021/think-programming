<?php
require_once 'includes/db.php';

echo "<h2>Admin Setup Utility (v1.1)</h2>";

try {
    // 1. Add role column if it doesn't exist
    $chk = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($chk->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user' AFTER password");
        echo "<p style='color: green;'>Added 'role' column to users table.</p>";
    } else {
        echo "<p>Column 'role' already exists.</p>";
    }

    // 2. Promote user to admin
    if (isset($_GET['promote'])) {
        $userToPromote = trim($_GET['promote']);
        
        // Try exact match first, then case-insensitive
        $stmt = $pdo->prepare("SELECT username FROM users WHERE LOWER(username) = LOWER(?)");
        $stmt->execute([$userToPromote]);
        $foundUser = $stmt->fetchColumn();

        if ($foundUser) {
            $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
            $stmt->execute([$foundUser]);
            echo "<p style='color: green;'>User '<strong>$foundUser</strong>' has been promoted to Admin!</p>";
        } else {
            echo "<p style='color: red;'>User '<strong>$userToPromote</strong>' not found.</p>";
            
            // List all users to help the user find the right one
            $allUsers = $pdo->query("SELECT username FROM users")->fetchAll(PDO::FETCH_COLUMN);
            if ($allUsers) {
                echo "<p><strong>Available usernames:</strong> " . implode(", ", $allUsers) . "</p>";
            } else {
                echo "<p>No users found in the database. Please register first.</p>";
            }
        }
    } else {
        echo "<p>To promote a user, visit: <code>admin_setup.php?promote=YOUR_USERNAME</code></p>";
    }

    echo "<p><a href='index.php'>Go to Home</a></p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
