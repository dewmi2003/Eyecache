<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../includes/db_connect.php';

// Assume user_id is stored in session after login
$user_id = $_SESSION['student'] ?? null;
if (!$user_id) {
    echo json_encode([]);
    exit;
}

// Fetch cart items with product details
$sql = "SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, c.quantity
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart = $result->fetch_all(MYSQLI_ASSOC);


$json = json_encode($cart);

if ($json === false) {
    echo "JSON encode error: " . json_last_error_msg();
} else {
    echo $json;
}


?>
