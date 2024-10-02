<?php
$host = 'localhost'; 
$db = 'pr_test';
$user = 'root'; 
$pass = 'lek1228'; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("failed: " . $e->getMessage());
}
?>
