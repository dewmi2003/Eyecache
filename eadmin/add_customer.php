<?php
session_start();
require 'db_connect.php'; // Make sure $pdo connects to your database

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$full_name = $email = $phone = "";
$success = $error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($full_name) || empty($email) || empty($phone)) {
        $error = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO customers (full_name, email, phone, created_at) VALUES (:full_name, :email, :phone, NOW())");
            $stmt->execute([
                ':full_name' => $full_name,
                ':email' => $email,
                ':phone' => $phone
            ]);
            header("Location: customers.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error adding customer: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Add Customer</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style>
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
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Add New Customer</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-8">

<?php if($error): ?>
<p class="text-red-600 font-semibold mb-4"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form class="space-y-6" method="POST" action="">
<div>
<h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Customer Information</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="md:col-span-2">
<label class="block text-sm font-medium text-gray-700" for="full_name">Full Name</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="full_name" name="full_name" placeholder="John Doe" type="text" value="<?= htmlspecialchars($full_name) ?>"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="email">Email Address</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="email" name="email" placeholder="john.doe@example.com" type="email" value="<?= htmlspecialchars($email) ?>"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="phone">Phone Number</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="phone" name="phone" placeholder="(555) 123-4567" type="tel" value="<?= htmlspecialchars($phone) ?>"/>
</div>
</div>
</div>

<div class="flex justify-end gap-4 mt-8">
<button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md" type="button" onclick="window.location.href='customers.php'">
Cancel
</button>
<button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2" type="submit">
<span class="material-symbols-outlined">person_add</span>
Save Customer
</button>
</div>
</form>
</div>
</main>
</div>
</body>
</html>
