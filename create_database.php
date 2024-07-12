<?php
require_once(dirname(__FILE__) . '/protected/vendor/autoload.php');

if (class_exists('Dotenv\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    throw new Exception('Dotenv class not found. Make sure vlucas/phpdotenv is installed.');
}

$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbUsername = $_ENV['DB_USERNAME'];
$dbPassword = $_ENV['DB_PASSWORD'];
$dbCharset = $_ENV['DB_CHARSET'];

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET $dbCharset COLLATE ${dbCharset}_general_ci";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->close();

