<?php
$servername ="localhost";
$username="root";
$password="@Rchitect1408";
$dbname="eyecache";

$connection=new mysqli($servername,$username,$password,$dbname);

$connection->set_charset("utf8mb4");

if ($connection->connect_error){
    die("Connection failed: ".$connection->connect_error);
}
?>
