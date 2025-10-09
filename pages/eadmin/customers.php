<?php 
session_start();
require '../../includes/db_connect.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
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
    $order_id = intval($_GET['delete_order']);
    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $order_id]);
    header("Location: customers.php");
    exit;
}

// Fetch customers
$stmt = $pdo->query("SELECT * FROM customers ORDER BY id DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders
$stmt2 = $pdo->query("SELECT * FROM orders ORDER BY order_id DESC");
$orders = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Panel - Customers & Orders</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  safelist: [
    'dark:bg-gray-900','dark:text-white','dark:bg-gray-800','dark:text-gray-200',
    'dark:border-gray-700','dark:hover:bg-gray-700','dark:text-gray-400'
  ]
};
</script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<style>:root { --primary-color: #FF2B68; }</style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">
<div class="flex h-screen">

  <!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

  <!-- Main content -->
  <main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">

    <!-- Customers Section -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Customers</h2>
      <button class="bg-[var(--primary-color)] hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-md flex items-center gap-2"
              onclick="window.location.href='add_customer.php'">
        <span class="material-symbols-outlined">add</span>Add Customer
      </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8 transition-colors">
      <?php if(!empty($customers)): ?>
      <table class="w-full text-left">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="p-4 font-semibold">ID</th>
          <th class="p-4 font-semibold">Full Name</th>
          <th class="p-4 font-semibold">Email</th>
          <th class="p-4 font-semibold">Phone</th>
          <th class="p-4 font-semibold">Created At</th>
          <th class="p-4 font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
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
      <p class="p-4 text-center text-gray-500 dark:text-gray-400">No customers found.</p>
      <?php endif; ?>
    </div>

    <!-- Orders Section -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Orders</h2>
      <button class="bg-[var(--primary-color)] hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-md flex items-center gap-2"
              onclick="window.location.href='add_order.php'">
        <span class="material-symbols-outlined">add</span>Add Order
      </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors">
      <?php if(!empty($orders)): ?>
      <table class="w-full text-left">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="p-4 font-semibold">Order ID</th>
          <th class="p-4 font-semibold">Customer ID</th>
          <th class="p-4 font-semibold">Order Date</th>
          <th class="p-4 font-semibold">Total Amount</th>
          <th class="p-4 font-semibold">Shipping Address</th>
          <th class="p-4 font-semibold">Status</th>
          <th class="p-4 font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php foreach($orders as $order): ?>
        <tr>
          <td class="p-4"><?= $order['order_id'] ?></td>
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
            <button class="text-blue-500 hover:text-blue-700 mx-1" onclick="window.location.href='edit_order.php?id=<?= $order['order_id'] ?>'">
              <span class="material-symbols-outlined">edit</span></button>
            <button class="text-red-500 hover:text-red-700 mx-1" onclick="if(confirm('Delete this order?')) window.location.href='customers.php?delete_order=<?= $order['order_id'] ?>'">
              <span class="material-symbols-outlined">delete</span></button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
      <?php else: ?>
      <p class="p-4 text-center text-gray-500 dark:text-gray-400">No orders found.</p>
      <?php endif; ?>
    </div>

  </main>
</div>

<!-- Dark Mode Toggle Script -->


</body>
</html>
