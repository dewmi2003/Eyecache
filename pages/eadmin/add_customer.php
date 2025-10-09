<?php
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$full_name = $email = $phone = "";
$success = $error = "";

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
<html lang="en" class="dark">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Add Customer</title>
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
  <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Add New Customer</h2>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors">

<?php if($error): ?>
<p class="text-red-600 dark:text-red-400 font-semibold mb-4"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form class="space-y-6" method="POST" action="">
<div>
  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b dark:border-gray-700 pb-2">Customer Information</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="full_name">Full Name</label>
      <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
             id="full_name" name="full_name" placeholder="John Doe" type="text" value="<?= htmlspecialchars($full_name) ?>"/>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="email">Email Address</label>
      <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
             id="email" name="email" placeholder="john.doe@example.com" type="email" value="<?= htmlspecialchars($email) ?>"/>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="phone">Phone Number</label>
      <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
             id="phone" name="phone" placeholder="(555) 123-4567" type="tel" value="<?= htmlspecialchars($phone) ?>"/>
    </div>
  </div>
</div>

<div class="flex justify-end gap-4 mt-8">
  <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-md transition-colors" 
          type="button" onclick="window.location.href='customers.php'">
    Cancel
  </button>
  <button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2 transition-colors" 
          type="submit">
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