<?php
require_once 'includes/db.php';

$tutorials = [
    // Python (category_id = 1)
    [1, 'Variables and Data Types in Python', '<p>Python has dynamically typed variables. You don\'t need to declare types explicitly.</p><pre><code>x = 5\ny = "Hello"</code></pre>'],
    [1, 'Python Control Flow', '<p>Learn about if statements, for loops, and while loops in Python.</p><pre><code>for i in range(5):\n    print(i)</code></pre>'],
    [1, 'Functions in Python', '<p>Use the <code>def</code> keyword to create functions.</p><pre><code>def greet(name):\n    return f"Hello {name}"</code></pre>'],
    
    // JavaScript (category_id = 2)
    [2, 'JavaScript DOM Manipulation', '<p>The Document Object Model connects web pages to scripts or programming languages. You can change text, styles, and elements.</p><pre><code>document.getElementById("demo").innerHTML = "Hello JS";</code></pre>'],
    [2, 'Modern ES6 Features', '<p>Explore let/const, arrow functions, and template literals.</p><pre><code>const add = (a, b) => a + b;</code></pre>'],
    [2, 'Async/Await in JS', '<p>Handle asynchronous operations neatly without callback hell.</p><pre><code>async function fetchData() {\n  let res = await fetch(url);\n}</code></pre>'],

    // PHP (category_id = 3)
    [3, 'Handling Forms in PHP', '<p>Learn how to capture POST and GET data.</p><pre><code>$name = $_POST["name"];</code></pre>'],
    [3, 'PHP Sessions and Cookies', '<p>Sessions are used to store information (in variables) to be used across multiple pages.</p><pre><code>session_start();\n$_SESSION["user"] = "admin";</code></pre>'],
    
    // Java (category_id = 4)
    [4, 'Introduction to OOP in Java', '<p>Java is built all around Objects and Classes. Understand encapsulation, inheritance, and polymorphism.</p><pre><code>class Car {\n  String color;\n}</code></pre>'],
    [4, 'Java Arrays and Lists', '<p>Store multiple values in a single variable.</p><pre><code>ArrayList<String> list = new ArrayList<>();</code></pre>'],
    
    // C++ (category_id = 5)
    [5, 'Pointers and References in C++', '<p>A pointer is a variable that stores the memory address as its value.</p><pre><code>int myAge = 43;\nint* ptr = &myAge;</code></pre>'],
    [5, 'Memory Management', '<p>Using new and delete manually.</p><pre><code>int* p = new int;\ndelete p;</code></pre>']
];

try {
    $stmt = $pdo->prepare("INSERT INTO tutorials (category_id, title, content) VALUES (?, ?, ?)");
    foreach ($tutorials as $t) {
        $stmt->execute($t);
    }
    echo "Tutorials injected successfully!\n";
} catch (Exception $e) {
    echo "Error inserting tutorials: " . $e->getMessage() . "\n";
}
?>
