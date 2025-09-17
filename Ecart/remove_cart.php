<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
$cart_id = $_POST['cart_id'] ?? 0;

if (!$user_id || !$cart_id) exit;

$sql = "DELETE FROM cart WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();

echo json_encode(['status' => 'success']);
?>
