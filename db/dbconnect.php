<?php
require_once __DIR__.'./dbhelpper.php';

try {
    if (class_exists('PDO')) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}