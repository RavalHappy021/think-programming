<?php
require_once 'includes/db.php';

echo "<h2>Starting Database Setup...</h2>";

try {
    // Read the SQL file
    $sql = file_get_contents('database.sql');
    
    // Remove CREATE DATABASE and USE statements to avoid permission issues on cloud hosts like Aiven
    // We assume the connection is already made to the correct database (e.g. defaultdb)
    $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS.*?;/i', '', $sql);
    $sql = preg_replace('/USE .*?;/i', '', $sql);
    
    // Execute the remaining SQL
    $pdo->exec($sql);
    
    echo "<p style='color: green;'>Tables and initial data created successfully!</p>";
    echo "<p><a href='index.php'>Go to Home</a> | <a href='tutorials.php'>Check Tutorials</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error during setup: " . $e->getMessage() . "</p>";
}
?>
