<?php
$host = 'localhost';
$dbname = 'nurse_db';
$username = 'root';
$password = 'ralphzs2169';

try {
    // Create a new PDO object
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set error mode to throw exceptions (helpful for debugging)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
