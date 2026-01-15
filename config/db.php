<?php
$host = 'localhost';
$dbname = 'ecommerce_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Attempt to create database if it doesn't exist
    try {
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
        $pdo->exec("USE $dbname");
        
        // Execute the SQL file to create tables
        $sql = file_get_contents(__DIR__ . '/../database.sql');
        $pdo->exec($sql);
        
    } catch(PDOException $e2) {
        die("Connection failed: " . $e2->getMessage());
    }
}
?>
