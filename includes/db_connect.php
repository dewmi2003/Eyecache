
<?php
$host = "sql105.ezyro.com";      // database host
$user = "ezyro_40089048";           // database username
$pass = "35c524865eae5";               // database password
$dbname = "ezyro_40089048_eyecache"; // change this to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");


if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
<?php
$host = "sql105.ezyro.com";      // database host
$user = "ezyro_40089048";           // database username
$pass = "35c524865eae5";               // database password
$dbname = "ezyro_40089048_eyecache"; // change this to your DB name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
?>

