<?php
$host = 'localhost';
$dbname = 'inventory_db';
$username = 'root';
$password = 'RootPassword123!';
$charset = 'utf8mb4';

try {
    // First connect without database to create it if needed
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET $charset COLLATE utf8mb4_general_ci");

    // Now connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create product table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS product (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(255) NOT NULL,
        supplier_name VARCHAR(255) NOT NULL,
        item_description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>