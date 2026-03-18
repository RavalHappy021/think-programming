<?php
// Router for Vercel to handle PHP files in the root directory
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Remove leading slash for local file matching
$file = ltrim($path, '/');

// If the path is empty or a directory, default to index.php
if ($file === '' || is_dir(__DIR__ . '/../' . $file)) {
    $file = rtrim($file, '/') . '/index.php';
}

// Append .php if it's missing (unless it's an asset)
if (!preg_match('/\.(php|js|css|png|jpg|jpeg|gif|svg|ico)$/i', $file)) {
    $file .= '.php';
}

$fullPath = __DIR__ . '/../' . ltrim($file, '/');

if (file_exists($fullPath) && is_file($fullPath)) {
    // Set the script filename for PHP includes to work correctly
    $_SERVER['SCRIPT_FILENAME'] = realpath($fullPath);
    include $fullPath;
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found: " . htmlspecialchars($file);
}
