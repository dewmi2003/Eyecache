<?php
include '../includes/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id    = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $size       = $_POST['size'] ?? '';
    $color      = $_POST['color'] ?? '';
    $quantity   = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if (!$user_id || !$product_id || empty($size) || empty($color)) {
        echo "error: missing required fields";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size, color, quantity) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "error: " . $conn->error;
        exit;
    }

    $stmt->bind_param("iissi", $user_id, $product_id, $size, $color, $quantity);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error: invalid request";
}
?>
