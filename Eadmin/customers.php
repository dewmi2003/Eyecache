<?php 
session_start();
require 'db_connect.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_form.php");
    exit;
}

// Handle deletion of customer
if (isset($_GET['delete_customer'])) {
    $id = intval($_GET['delete_customer']);
    $stmt = $pdo->prepare("DELETE FROM customers WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: customers.php");
    exit;
}

// Handle deletion of order
if (isset($_GET['delete_order'])) {
    $id = intval($_GET['delete_order']);
    $stmt = $pdo->prepare("DELETE FROM orders1 WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: customers.php");
    exit;
}

// Fetch customers
$stmt = $pdo->query("SELECT * FROM customers ORDER BY id DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders
$stmt2 = $pdo->query("SELECT * FROM orders1 ORDER BY id DESC");
$orders = $stmt2->fetchAll(PDO::FETCH_ASSOC); // <-- changed variable name to $orders
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Customers & Orders</title>
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
<a class="flex items-center gap-3 px-4 py-2 rounded-md bg-[var(--primary-color)] text-white font-medium" href="customers.php">
<span class="material-symbols-outlined">people</span><span>Customers</span></a>
</nav>
<div class="px-4 py-4 border-t">
<div class="flex items-center gap-3 mb-4">
<img alt="User Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDsnnO_zYh00P_h9W9wfQEPKdkyZC3EQStflmIz19ZTAM8FehcV6CtGWnacI5Dg6JIGqc2H69DrRMt5YdznX0aO_okymxK52o6SMIhmnABRklLKPKXuq1FNYTUfe8YzrtDzBgjoAxHVUp1Z228UYBOSOx-LpgPgQ-oP6a5WOpsY3WlOM4qWXmSybwEr6iuod6qlsOhUv1WQStexmNJRul9qbhIusfe1Dc9h-KMt4M1OcZANfE2cPGciS_3Xubg1-J9JoDgjS5WPUpUq"/>
<div>
<p class="font-semibold"><?= $_SESSION['admin_full_name'] ?? 'Admin' ?></p>
<p class="text-sm text-gray-500"><?= $_SESSION['admin_role'] ?? 'Administrator' ?></p>
</div>
</div>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="logout.php">
<span class="material-symbols-outlined">logout</span><span>Logout</span></a>
</div>
</div>
</aside>

<!-- Main content -->
<main class="flex-1 p-8 overflow-y-auto">

<!-- Customers Section -->
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Customers</h2>
<button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2" onclick="window.location.href='add_customer.php'">
<span class="material-symbols-outlined">add</span>Add New Customer
</button>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
<?php if(!empty($customers)): ?>
<table class="w-full text-left">
<thead class="bg-gray-100">
<tr>
<th class="p-4 font-semibold">ID</th>
<th class="p-4 font-semibold">Full Name</th>
<th class="p-4 font-semibold">Email</th>
<th class="p-4 font-semibold">Phone</th>
<th class="p-4 font-semibold">Created At</th>
<th class="p-4 font-semibold text-center">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
<?php foreach($customers as $customer): ?>
<tr>
<td class="p-4"><?= $customer['id'] ?></td>
<td class="p-4 font-medium"><?= htmlspecialchars($customer['full_name']) ?></td>
<td class="p-4"><?= htmlspecialchars($customer['email']) ?></td>
<td class="p-4"><?= htmlspecialchars($customer['phone']) ?></td>
<td class="p-4"><?= $customer['created_at'] ?></td>
<td class="p-4 text-center">
<button class="text-blue-500 hover:text-blue-700 mx-1" onclick="window.location.href='edit_customer.php?id=<?= $customer['id'] ?>'">
<span class="material-symbols-outlined">edit</span></button>
<button class="text-red-500 hover:text-red-700 mx-1" onclick="if(confirm('Delete this customer?')) window.location.href='customers.php?delete_customer=<?= $customer['id'] ?>'">
<span class="material-symbols-outlined">delete</span></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p class="p-4 text-center text-gray-500">No customers found.</p>
<?php endif; ?>
</div>

<!-- Orders Section -->
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Orders</h2>
<button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2" onclick="window.location.href='add_order.php'">
<span class="material-symbols-outlined">add</span>Add New Order
</button>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
<?php if(!empty($orders)): ?>
<table class="w-full text-left">
<thead class="bg-gray-100">
<tr>
<th class="p-4 font-semibold">ID</th>
<th class="p-4 font-semibold">Customer ID</th>
<th class="p-4 font-semibold">Order Date</th>
<th class="p-4 font-semibold">Total Amount</th>
<th class="p-4 font-semibold">Shipping Address</th>
<th class="p-4 font-semibold">Status</th>
<th class="p-4 font-semibold text-center">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
<?php foreach($orders as $order): ?>
<tr>
<td class="p-4"><?= $order['id'] ?></td>
<td class="p-4"><?= $order['customer_id'] ?></td>
<td class="p-4"><?= $order['order_date'] ?></td>
<td class="p-4"><?= $order['total_amount'] ?></td>
<td class="p-4"><?= htmlspecialchars($order['shipping_address']) ?></td>
<td class="p-4">
<?php 
$status = $order['status'];
$color = ['Completed'=>'green','Pending'=>'yellow','Shipped'=>'blue','Cancelled'=>'red'][$status] ?? 'gray';
?>
<span class="px-2 py-1 text-xs font-semibold text-<?= $color ?>-800 bg-<?= $color ?>-200 rounded-full"><?= $status ?></span>
</td>
<td class="p-4 text-center">
<button class="text-blue-500 hover:text-blue-700 mx-1" onclick="window.location.href='edit_order.php?id=<?= $order['id'] ?>'">
<span class="material-symbols-outlined">edit</span></button>
<button class="text-red-500 hover:text-red-700 mx-1" onclick="if(confirm('Delete this order?')) window.location.href='customers.php?delete_order=<?= $order['id'] ?>'">
<span class="material-symbols-outlined">delete</span></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p class="p-4 text-center text-gray-500">No orders found.</p>
<?php endif; ?>
</div>

</main>
</div>
</body>
</html>
