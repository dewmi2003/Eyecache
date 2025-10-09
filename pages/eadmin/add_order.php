<?php
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// Initialize variables
$user_id = $order_date = $total_amount = $shipping_address = $status = "";
$error = "";

// Rest of your PHP logic remains the same...
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Add New Order</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    'dark:text-gray-400'
  ]
};
</script>
<style>
:root {
  --primary-color: #FF2B68;
  --primary-hover-color: #B3124A;
}
</style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">

<div class="flex h-screen">

<!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

<main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">
<div class="flex justify-between items-center mb-8">
  <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Add New Order</h2>
</div>

<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-colors">

<?php if ($error): ?>
<p class="text-red-600 dark:text-red-400 font-semibold mb-4"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form class="space-y-6" method="POST" action="">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="user_id">User ID</label>
    <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
           id="user_id" name="user_id" placeholder="Enter User ID" type="number" value="<?= htmlspecialchars($user_id) ?>"/>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="order_date">Order Date</label>
    <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
           id="order_date" name="order_date" type="date" value="<?= htmlspecialchars($order_date) ?>"/>
  </div>
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="total_amount">Total Amount</label>
  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
      <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
    </div>
    <input class="block w-full rounded-md border-gray-300 dark:border-gray-600 pl-7 pr-12 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
           id="total_amount" name="total_amount" placeholder="0.00" type="text" value="<?= htmlspecialchars($total_amount) ?>"/>
  </div>
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="shipping_address">Shipping Address</label>
  <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
            id="shipping_address" name="shipping_address" placeholder="123 Main St, Anytown, USA" rows="3"><?= htmlspecialchars($shipping_address) ?></textarea>
</div>

<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="status">Status</label>
  <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 py-2 pl-3 pr-10 text-base focus:border-[var(--primary-color)] focus:outline-none focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
          id="status" name="status">
    <option <?= $status=="Pending"?"selected":"" ?>>Pending</option>
    <option <?= $status=="Shipped"?"selected":"" ?>>Shipped</option>
    <option <?= $status=="Completed"?"selected":"" ?>>Completed</option>
    <option <?= $status=="Cancelled"?"selected":"" ?>>Cancelled</option>
  </select>
</div>

<div class="flex justify-end space-x-4">
  <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-md transition-colors" 
          type="button" onclick="window.location.href='customers.php'">
    Cancel
  </button>
  <button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2 transition-colors" 
          type="submit">
    <span class="material-symbols-outlined">add</span>
    Create Order
  </button>
</div>
</form>
</div>
</main>
</div>
</body>
</html>