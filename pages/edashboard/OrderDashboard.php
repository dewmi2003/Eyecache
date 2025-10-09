<?php
session_start();
include("../../includes/db_connect.php");
include("../../includes/navbar.php");

if (!isset($_SESSION['student'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['student'];

// Pending orders
$pending_stmt = $conn->prepare(
    "SELECT order_id, product_name, quantity, price, order_date, expected_date 
     FROM orders 
     WHERE user_id=? AND status='pending'
     ORDER BY order_date DESC"
);
if (!$pending_stmt) die("Prepare failed: " . $conn->error);
$pending_stmt->bind_param("i", $user_id);
$pending_stmt->execute();
$pending_orders = $pending_stmt->get_result();
$pending_stmt->close();

// Completed orders
$completed_stmt = $conn->prepare(
    "SELECT order_id, product_name, quantity, price, order_date, expected_date 
     FROM orders 
     WHERE user_id=? AND status='completed'
     ORDER BY order_date DESC"
);
if (!$completed_stmt) die("Prepare failed: " . $connection->error);
$completed_stmt->bind_param("i", $user_id);
$completed_stmt->execute();
$completed_orders = $completed_stmt->get_result();
$completed_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Dashboard</title>
<!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   <link href="/assets/css/lm.css" rel="stylesheet"/>
<style>
        /* Navbar */
        .navbar.fixed-top {
            background-color: var(--base-variant) ;
            padding: 1rem 2rem;
            box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2);
            z-index: 1000;
        }

        .navbar-brand {
            color: #FF2B68 !important;
            font-weight: bold;
            font-size: 2rem;
            transition: transform 0.3s;
        }

        .navbar-brand:hover {
            transform: scale(1.1);
            color: #ff4c80 !important;
        }

        .navbar-nav .nav-link {
            color: #FF2B68 !important;
            font-weight: 600;
            margin-left: 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s, transform 0.3s;
        }

        .navbar-nav .nav-link i {
            font-size: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #ff4c80 !important;
            transform: translateY(-2px);
        }
body {
    font-family: 'Poppins', sans-serif;
    background: #111;
    color: #eee;
    margin: 0;
    padding: 120px 5% 50px 5%;
}

h2 {
    color: #ff3c78;
    margin: 30px 0 15px 0;
    font-size:1.8rem;
    font-weight:bold;
}

.orders-container {
    display: flex;
    flex-direction: column;
    gap:20px;
   
}

.order-card {
    background: #1b1b1b;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.6);
    width:100%;
    color: #eee;
}

.order-card h3 {
    margin: 0 0 15px 0;
    color: #ff3c78;
    border-bottom:1px solid #333;
    padding-bottom:8px;
    font-size:1rem;
}

.order-card p {
    display:flex;
    justify-content:space-between;
    margin: 10px 0;
    font-size: 1.0rem;
    line-height: 1.5;
    padding-bottom: 8px;
    border-bottom: 1px solid #333;
    color:#aaa
}

.order-card p:last-child {
    border-bottom: none;
}

.status {
    font-weight: 600;
}

.status-pending {
    color: #e74c3c; /* Red text */
}

.status-completed {
    color: #27ae60; /* Green text */
}

.no-orders {
    font-style: italic;
    color: #bbb;
    margin-bottom: 20px;
}

footer {
    text-align: center;
    margin-top: 50px;
    padding: 15px 0;
    background: #222;
    border-top: 1px solid #333;
    color: #ccc;
}

/* Responsive layout */


</style>
    <link href="../../assets/css/theme.css" rel="stylesheet"/>
</head>
<body>

<h2>Pending Orders</h2>
<div class="orders-container">
    <?php if($pending_orders->num_rows > 0): ?>
        <?php while($order = $pending_orders->fetch_assoc()): ?>
            <div class="order-card">
                <h3>OrderID: <?= $order['order_id'] ?></h3>
                <p><strong>Product            :</strong> <?= htmlspecialchars($order['product_name']) ?></p>
                <p><strong>Quantity           :</strong> <?= $order['quantity'] ?></p>
                <p><strong>Price              :</strong> Rs.<?= $order['price'] ?></p>
                <p><strong>Ordered on         :</strong> <?= $order['order_date'] ?></p>
                <p><strong>Expected Delivery  :</strong> <?= !empty($order['expected_date']) ? $order['expected_date'] : 'N/A' ?></p>
                <p>Status: <span class="status status-pending">Pending</span></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-orders">No pending orders.</p>
    <?php endif; ?>
</div>

<h2>Previous Orders</h2>
<div class="orders-container">
    <?php if($completed_orders->num_rows > 0): ?>
        <?php while($order = $completed_orders->fetch_assoc()): ?>
            <div class="order-card">
                <h3>OrderID: <?= $order['order_id'] ?></h3>
                <p><strong>Product: </strong> <?= htmlspecialchars($order['product_name']) ?></p>
                <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
                <p><strong>Price:</strong> Rs.<?= $order['price'] ?></p>
                <p><strong>Ordered on:</strong> <?= $order['order_date'] ?></p>
                <p><strong>Expected Delivery:   </strong> <?= !empty($order['expected_date']) ? $order['expected_date'] : 'N/A' ?></p>
                <p>Status: <span class="status status-completed">Completed</span></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-orders">No previous orders.</p>
    <?php endif; ?>
</div>

<footer>
  &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>
<script src="/assets/js/lm.js">
  
</script>
</body>
</html>
