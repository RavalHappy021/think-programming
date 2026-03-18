<?php
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);
    echo "Database setup successful.";
} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
}
?>
