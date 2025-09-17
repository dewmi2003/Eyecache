<?php
$host = "localhost";      // database host
$user = "root";           // database username
$pass = "root";               // database password
$dbname = "eyecache"; // change this to your DB name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
?>
