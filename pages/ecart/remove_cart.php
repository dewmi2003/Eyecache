<?php
session_start();
include '../../includes/db_connect.php';

$user_id = $_SESSION['student'] ?? null;
$cart_id = $_POST['cart_id'] ?? 0;

if (!$user_id || !$cart_id) exit;

$sql = "DELETE FROM cart WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();

echo json_encode(['status' => 'success']);
if ($json === false) {
    echo "JSON encode error: " . json_last_error_msg();
} else {
    echo $json;
}
?>
