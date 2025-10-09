<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

include '../../includes/db_connect.php';

// Handle approve
if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']);
    $stmt = $pdo->prepare("UPDATE users SET is_approved = 1 WHERE id = ?");
    $stmt->execute([$approve_id]);
    header("Location: users.php");
    exit;
}

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt_delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt_delete->execute([$delete_id]);
    header("Location: users.php");
    exit;
}

// Fetch awaiting approval
$users_tba = $pdo->query("SELECT * FROM users WHERE is_approved = 0 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch approved users
$users = $pdo->query("SELECT * FROM users WHERE is_approved = 1 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Users</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  safelist: ['dark:bg-gray-900','dark:bg-gray-800','dark:text-white','dark:text-gray-200','dark:divide-gray-700','dark:hover:bg-gray-700']
};
</script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<style>
:root { --primary-color: #FF2B68; --primary-hover-color: #B3124A; }
</style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">

<div class="flex h-screen">

<!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

<!-- Main -->
<main class="flex-1 p-6 lg:p-8 overflow-auto bg-gray-50 dark:bg-gray-900 transition-colors">

<div class="flex justify-between items-center mb-8">
  <h2 class="text-4xl font-bold">Users Management</h2>
  <button onclick="window.location.href='add_user.php'" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
    <span class="material-symbols-outlined">add</span>Add New User
  </button>
</div>

<!-- Awaiting Approval -->
<div class="mb-12">
  <h3 class="text-2xl font-semibold mb-4">Awaiting Approval</h3>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full text-left">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="p-4 font-semibold">Full Name</th>
          <th class="p-4 font-semibold">Email</th>
          <th class="p-4 font-semibold">Address</th>
          <th class="p-4 font-semibold">City</th>
          <th class="p-4 font-semibold">Postal Code</th>
          <th class="p-4 font-semibold">Phone</th>
          <th class="p-4 font-semibold">Role Requested</th>
          <th class="p-4 font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if(!empty($users_tba)): foreach($users_tba as $user): ?>
        <tr>
          <td class="p-4"><?= htmlspecialchars($user['full_name']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['address']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['city']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['postal_code']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['phone']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['role']) ?></td>
          <td class="p-4 text-center">
            <a href="?approve_id=<?= $user['id'] ?>" class="text-green-500 hover:text-green-700 mx-1"><span class="material-symbols-outlined">check_circle</span></a>
            <a href="?delete_id=<?= $user['id'] ?>" class="text-red-500 hover:text-red-700 mx-1" onclick="return confirm('Are you sure?');"><span class="material-symbols-outlined">delete</span></a>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-400">No users awaiting approval.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Approved Users -->
<div>
  <h3 class="text-2xl font-semibold mb-4">Users</h3>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full text-left">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="p-4 font-semibold">Full Name</th>
          <th class="p-4 font-semibold">Email</th>
          <th class="p-4 font-semibold">Address</th>
          <th class="p-4 font-semibold">City</th>
          <th class="p-4 font-semibold">Postal Code</th>
          <th class="p-4 font-semibold">Phone</th>
          <th class="p-4 font-semibold">Role</th>
          <th class="p-4 font-semibold">Created At</th>
          <th class="p-4 font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if(!empty($users)): foreach($users as $user): ?>
        <tr>
          <td class="p-4"><?= htmlspecialchars($user['full_name']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['address']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['city']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['postal_code']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['phone']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['role']) ?></td>
          <td class="p-4"><?= htmlspecialchars($user['created_at']) ?></td>
          <td class="p-4 text-center">
            <a href="edit_user.php?id=<?= $user['id'] ?>" class="text-blue-500 hover:text-blue-700 mx-1"><span class="material-symbols-outlined">edit</span></a>
            <a href="?delete_id=<?= $user['id'] ?>" class="text-red-500 hover:text-red-700 mx-1" onclick="return confirm('Are you sure?');"><span class="material-symbols-outlined">delete</span></a>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="9" class="p-4 text-center text-gray-500 dark:text-gray-400">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</main>
</div>


</body>
</html>
