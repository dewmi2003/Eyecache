<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Check order ID passed
if (!isset($_GET['id'])) {
    header("Location: customers.php"); // redirect back to customers/orders list
    exit;
}

$order_id = intval($_GET['id']);

// Fetch the order
$stmt = $pdo->prepare("SELECT * FROM orders1 WHERE id = :id");
$stmt->execute([':id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit;
}

// Fetch all customers for dropdown
$customers_stmt = $pdo->query("SELECT id, full_name FROM customers ORDER BY full_name ASC");
$customers = $customers_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? '';
    $order_date = $_POST['order_date'] ?? '';
    $total_amount = $_POST['total_amount'] ?? '';
    $shipping_address = $_POST['shipping_address'] ?? '';
    $status = $_POST['status'] ?? '';

    $stmt = $pdo->prepare("UPDATE orders1 SET customer_id = :customer_id, order_date = :order_date, total_amount = :total_amount, shipping_address = :shipping_address, status = :status WHERE id = :id");
    $stmt->execute([
        ':customer_id' => $customer_id,
        ':order_date' => $order_date,
        ':total_amount' => $total_amount,
        ':shipping_address' => $shipping_address,
        ':status' => $status,
        ':id' => $order_id
    ]);

    header("Location: customers.php"); // redirect after update
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Edit Order</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
:root {
  --primary-color: #1173d4;
  --primary-hover-color: #0e5aab;
}
</style>
</head>
<body class="bg-gray-50 font-sans">
<div class="flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white text-gray-800 flex flex-col shadow-lg">
<div class="px-6 py-4 flex items-center gap-3 border-b">
<div class="p-2 bg-[var(--primary-color)] rounded-full text-white">
<span class="material-symbols-outlined">store</span>
</div>
<h1 class="text-xl font-bold">Admin Panel</h1>
</div>
<div class="flex-1 flex flex-col justify-between">
<nav class="px-4 py-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="home.php">
<span class="material-symbols-outlined">home</span><span>Home</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="products.php">
<span class="material-symbols-outlined">inventory_2</span><span>Products</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="users.php">
<span class="material-symbols-outlined">group</span><span>Users</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md bg-blue-500 text-white font-medium" href="customers.php">
<span class="material-symbols-outlined">people</span><span>Customers</span></a>
</nav>
<div class="px-4 py-4 border-t">
<div class="flex items-center gap-3 mb-4">
<img alt="User Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDsnnO_zYh00P_h9W9wfQEPKdkyZC3EQStflmIz19ZTAM8FehcV6CtGWnacI5Dg6JIGqc2H69DrRMt5YdznX0aO_okymxK52o6SMIhmnABRklLKPKXuq1FNYTUfe8YzrtDzBgjoAxHVUp1Z228UYBOSOx-LpgPgQ-oP6a5WOpsY3WlOM4qWXmSybwEr6iuod6qlsOhUv1WQStexmNJRul9qbhIusfe1Dc9h-KMt4M1OcZANfE2cPGciS_3Xubg1-J9JoDgjS5WPUpUq"/>
<div>
<p class="font-semibold"><?php echo $_SESSION['admin_full_name'] ?? 'Admin'; ?></p>
<p class="text-sm text-gray-500"><?php echo $_SESSION['admin_role'] ?? 'Administrator'; ?></p>
</div>
</div>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="logout.php">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
</aside>

<main class="flex-1 p-8 overflow-y-auto">
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Edit Order</h2>
</div>
<div class="bg-white p-8 rounded-lg shadow-md">
<form class="space-y-6" method="POST">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700" for="customer-id">Customer</label>
<select id="customer-id" name="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
<?php foreach($customers as $c): ?>
<option value="<?= $c['id'] ?>" <?= ($order['customer_id'] == $c['id']) ? 'selected' : '' ?>>
<?= htmlspecialchars($c['full_name']) ?>
</option>
<?php endforeach; ?>
</select>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="order-date">Order Date</label>
<input type="date" id="order-date" name="order_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" value="<?= $order['order_date'] ?>"/>
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="total-amount">Total Amount</label>
<div class="mt-1 relative rounded-md shadow-sm">
<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
<span class="text-gray-500 sm:text-sm">$</span>
</div>
<input type="text" id="total-amount" name="total_amount" class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" value="<?= $order['total_amount'] ?>"/>
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="shipping-address">Shipping Address</label>
<textarea id="shipping-address" name="shipping_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm"><?= htmlspecialchars($order['shipping_address']) ?></textarea>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="status">Status</label>
<select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-[var(--primary-color)] focus:outline-none focus:ring-[var(--primary-color)] sm:text-sm">
<option value="Pending" <?= ($order['status']=='Pending')?'selected':'' ?>>Pending</option>
<option value="Shipped" <?= ($order['status']=='Shipped')?'selected':'' ?>>Shipped</option>
<option value="Completed" <?= ($order['status']=='Completed')?'selected':'' ?>>Completed</option>
<option value="Cancelled" <?= ($order['status']=='Cancelled')?'selected':'' ?>>Cancelled</option>
</select>
</div>

<div class="flex justify-end space-x-4">
<button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md" onclick="window.location.href='customers.php'">Cancel</button>
<button type="submit" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
<span class="material-symbols-outlined">save</span> Update Order
</button>
</div>
</form>
</div>
</main>
</div>
</body>
</html>
