<?php

$host = 'localhost';
$dbname = 'imobis';
$username = 'root';
$user_password = '';

$dsn = "mysql:dbname=$dbname;host=$host;";

try {
    $pdo = new PDO($dsn, $username, $user_password);
} catch (Exception $e) {
    die($e->getMessage());
}
