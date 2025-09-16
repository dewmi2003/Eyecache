<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

// Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a session-based user ID if not exists
if (!isset($_SESSION['cart_user_id'])) {
    $_SESSION['cart_user_id'] = session_id();
}

$user_id = $_SESSION['cart_user_id'];

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Check if product exists
    $check = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $check->bind_param("i", $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Check if product already in cart for this user
        $checkCart = $conn->prepare("SELECT quantity FROM cart WHERE product_id = ? AND user_id = ?");
        $checkCart->bind_param("is", $product_id, $user_id);
        $checkCart->execute();
        $cartResult = $checkCart->get_result();

        if ($cartResult->num_rows > 0) {
            // Increment quantity
            $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ? AND user_id = ?");
            $update->bind_param("is", $product_id, $user_id);
            if ($update->execute()) {
                echo json_encode(["status" => "success", "message" => "Product quantity updated in cart"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update cart: " . $update->error]);
            }
        } else {
            // Insert new product
            $insert = $conn->prepare("INSERT INTO cart (product_id, quantity, user_id, added_at) VALUES (?, 1, ?, NOW())");
            $insert->bind_param("is", $product_id, $user_id);
            if ($insert->execute()) {
                echo json_encode(["status" => "success", "message" => "Product added to cart"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add to cart: " . $insert->error]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid product ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No product ID provided"]);
}

?>
