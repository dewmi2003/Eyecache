<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


$totalProductsStmt = $pdo->query("SELECT COUNT(*) AS total FROM products");
$totalProducts = $totalProductsStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;


$totalOrdersStmt = $pdo->query("SELECT COUNT(*) AS total FROM orders");
$totalOrders = $totalOrdersStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;


$totalCustomersStmt = $pdo->query("SELECT COUNT(*) AS total FROM customers");
$totalCustomers = $totalCustomersStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;


$totalSalesStmt = $pdo->query("SELECT SUM(total_amount) AS total FROM orders");
$totalSales = $totalSalesStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel</title>
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


<aside class="w-64 bg-white text-gray-800 flex flex-col shadow-lg">
<div class="px-6 py-4 flex items-center gap-3 border-b">
<div class="p-2 bg-[var(--primary-color)] rounded-full text-white">
<span class="material-symbols-outlined">store</span>
</div>
<h1 class="text-xl font-bold">Admin Panel</h1>
</div>
<div class="flex-1 flex flex-col justify-between">
<nav class="px-4 py-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-2 rounded-md bg-[var(--primary-color)] text-white font-medium" href="home.php">
<span class="material-symbols-outlined">home</span><span>Home</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="products.php">
<span class="material-symbols-outlined">inventory_2</span><span>Products</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="users.php">
<span class="material-symbols-outlined">group</span><span>Users</span></a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="customers.php">
<span class="material-symbols-outlined">people</span><span>Customers</span></a>
</nav>
<div class="px-4 py-4 border-t">
<div class="flex items-center gap-3 mb-4">
<img alt="User Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDsnnO_zYh00P_h9W9wfQEPKdkyZC3EQStflmIz19ZTAM8FehcV6CtGWnacI5Dg6JIGqc2H69DrRMt5YdznX0aO_okymxK52o6SMIhmnABRklLKPKXuq1FNYTUfe8YzrtDzBgjoAxHVUp1Z228UYBOSOx-LpgPgQ-oP6a5WOpsY3WlOM4qWXmSybwEr6iuod6qlsOhUv1WQStexmNJRul9qbhIusfe1Dc9h-KMt4M1OcZANfE2cPGciS_3Xubg1-J9JoDgjS5WPUpUq"/>
<div>
<p class="font-semibold"><?php echo $_SESSION['admin_full_name']; ?></p>
<p class="text-sm text-gray-500"><?php echo $_SESSION['admin_role']; ?></p>
</div>
</div>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors mt-2" href="logout.php">
<span class="material-symbols-outlined">logout</span><span>Logout</span></a>
</div>
</div>
</aside>

<main class="flex-1 p-8 overflow-y-auto">
<h2 class="text-4xl font-bold text-gray-800 mb-8">Dashboard</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">


<div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
<div>
<p class="text-gray-500 text-sm font-medium">Total Products</p>
<p class="text-3xl font-bold text-gray-800"><?= $totalProducts ?></p>
</div>
<div class="p-3 bg-blue-100 rounded-full">
<span class="material-symbols-outlined text-blue-500">inventory_2</span>
</div>
</div>


<div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
<div>
<p class="text-gray-500 text-sm font-medium">Total Orders</p>
<p class="text-3xl font-bold text-gray-800"><?= $totalOrders ?></p>
</div>
<div class="p-3 bg-green-100 rounded-full">
<span class="material-symbols-outlined text-green-500">shopping_cart</span>
</div>
</div>


<div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
<div>
<p class="text-gray-500 text-sm font-medium">Total Customers</p>
<p class="text-3xl font-bold text-gray-800"><?= $totalCustomers ?></p>
</div>
<div class="p-3 bg-yellow-100 rounded-full">
<span class="material-symbols-outlined text-yellow-500">people</span>
</div>
</div>


<div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
<div>
<p class="text-gray-500 text-sm font-medium">Total Sales</p>
<p class="text-3xl font-bold text-gray-800">$<?= number_format($totalSales, 2) ?></p>
</div>
<div class="p-3 bg-red-100 rounded-full">
<span class="material-symbols-outlined text-red-500">attach_money</span>
</div>
</div>

</div>
</main>
</div>
</body>
</html>
