<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id    = $_POST['user_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $size       = $_POST['size'] ?? '';
    $color      = $_POST['color'] ?? '';
    $quantity   = $_POST['quantity'] ?? 1;

    if (empty($user_id) || empty($product_id) || empty($size) || empty($color)) {
        echo "error: missing required fields";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size, color, quantity) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "error: " . $conn->error;
        exit;
    }

    // user_id = string, product_id = int, size = string, color = string, quantity = int
    $stmt->bind_param("sissi", $user_id, $product_id, $size, $color, $quantity);

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
