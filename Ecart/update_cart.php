<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if (!$user_id || !$product_id) exit;

// Check if item already in cart
$sql = "SELECT id FROM cart WHERE user_id=? AND product_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity
    $sql = "UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt->execute();
} else {
    // Add new item
    $sql = "INSERT INTO cart (user_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
}

echo json_encode(['status' => 'success']);
?>
