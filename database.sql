CREATE DATABASE IF NOT EXISTS think_programming;
USE think_programming;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    icon VARCHAR(50) DEFAULT 'code',
    description TEXT
);

CREATE TABLE IF NOT EXISTS tutorials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    video_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS practice_modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(150) NOT NULL,
    question TEXT NOT NULL,
    expected_output TEXT,
    difficulty VARCHAR(20) DEFAULT 'Beginner',
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS examples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(150) NOT NULL,
    code_snippet TEXT NOT NULL,
    explanation TEXT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Insert dummy categories
INSERT IGNORE INTO categories (name, slug, icon, description) VALUES
('Python', 'python', 'fab fa-python', 'Learn Python from scratch. Great for data science and web development.'),
('JavaScript', 'javascript', 'fab fa-js', 'The language of the web. Build interactive websites.'),
('PHP', 'php', 'fab fa-php', 'Server-side scripting language for web development.'),
('Java', 'java', 'fab fa-java', 'Object-oriented programming language for enterprise apps.'),
('C++', 'cpp', 'fas fa-code', 'High-performance applications and system programming.');

-- Insert dummy tutorials
INSERT IGNORE INTO tutorials (category_id, title, content) VALUES
(1, 'Introduction to Python', '<p>Python is a versatile language...</p>'),
(2, 'JavaScript Variables', '<p>In JS, you can use let, const, or var...</p>'),
(3, 'PHP Basics', '<p>PHP code runs on the server...</p>');
