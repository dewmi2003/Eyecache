<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include '../../includes/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// Sample dynamic data
$totalProducts  = $pdo->query("SELECT COUNT(*) AS total FROM products")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalOrders    = $pdo->query("SELECT COUNT(*) AS total FROM orders")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalCustomers = $pdo->query("SELECT COUNT(*) AS total FROM customers")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalSales     = $pdo->query("SELECT SUM(price) AS total FROM orders")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en" class="dark"> <!-- Default to dark -->
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>

  <!-- ✅ Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <!-- ✅ Tailwind dark mode config -->
  <script>
    tailwind.config = {
      darkMode: 'class',
      safelist: [
        'dark:bg-gray-900',
        'dark:text-white',
        'dark:bg-gray-800',
        'dark:text-gray-200',
        'dark:border-gray-700',
        'dark:hover:bg-gray-700',
        'dark:bg-blue-900',
        'dark:bg-green-900',
        'dark:bg-yellow-900',
        'dark:bg-red-900',
        'dark:text-gray-400',
        'dark:text-yellow-300'
      ]
    };
  </script>

  <!-- ✅ Google Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

  <style>
    :root {
      --primary-color: #FF2B68;
    }
  </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">

<div class="flex h-screen">

  <!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

  <!-- Main Content -->
  <main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">
    <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mb-8">Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Cards -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors">
        <div>
          <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Products</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-white"><?= $totalProducts ?></p>
        </div>
        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
          <span class="material-symbols-outlined text-blue-500">inventory_2</span>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors">
        <div>
          <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Orders</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-white"><?= $totalOrders ?></p>
        </div>
        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
          <span class="material-symbols-outlined text-green-500">shopping_cart</span>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors">
        <div>
          <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Customers</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-white"><?= $totalCustomers ?></p>
        </div>
        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
          <span class="material-symbols-outlined text-yellow-500">people</span>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors">
        <div>
          <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Sales</p>
          <p class="text-3xl font-bold text-gray-800 dark:text-white">$<?= number_format($totalSales, 2) ?></p>
        </div>
        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
          <span class="material-symbols-outlined text-red-500">attach_money</span>
        </div>
      </div>

    </div>
  </main>
</div>

<!-- ✅ Dark Mode Toggle Script -->


</body>
</html>
