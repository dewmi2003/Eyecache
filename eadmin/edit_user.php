<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_form.php");
    exit;
}

require_once "db_connect.php";

$errors = [];
$success = '';

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$user_id = intval($_GET['id']);

// Fetch existing user
try {
    $stmt = $pdo->prepare("SELECT full_name, email, role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: users.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching user: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full-name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if (empty($full_name)) $errors[] = "Full Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if ($password && $password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($role)) $errors[] = "Role is required.";

    if (empty($errors)) {
        try {
            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, role = ?, password = ? WHERE id = ?");
                $stmt->execute([$full_name, $email, $role, $password_hash, $user_id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, role = ? WHERE id = ?");
                $stmt->execute([$full_name, $email, $role, $user_id]);
            }

            $success = "User updated successfully!";
            // Refresh user data
            $stmt = $pdo->prepare("SELECT full_name, email, role FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $errors[] = "Error updating user: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Edit User</title>
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
        <a href="home.php" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors">
          <span class="material-symbols-outlined">home</span>Home
        </a>
        <a href="products.php" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors">
          <span class="material-symbols-outlined">inventory_2</span>Products
        </a>
        <a href="users.php" class="flex items-center gap-3 px-4 py-2 rounded-md bg-[var(--primary-color)] text-white font-medium">
          <span class="material-symbols-outlined">group</span>Users
        </a>
        <a href="customers.php" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors">
          <span class="material-symbols-outlined">people</span>Customers
        </a>
      </nav>
      <div class="px-4 py-4 border-t">
        <div class="flex items-center gap-3 mb-4">
          <img alt="User Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDsnnO_zYh00P_h9W9wfQEPKdkyZC3EQStflmIz19ZTAM8FehcV6CtGWnacI5Dg6JIGqc2H69DrRMt5YdznX0aO_okymxK52o6SMIhmnABRklLKPKXuq1FNYTUfe8YzrtDzBgjoAxHVUp1Z228UYBOSOx-LpgPgQ-oP6a5WOpsY3WlOM4qWXmSybwEr6iuod6qlsOhUv1WQStexmNJRul9qbhIusfe1Dc9h-KMt4M1OcZANfE2cPGciS_3Xubg1-J9JoDgjS5WPUpUq"/>
          <div>
            <p class="font-semibold"><?php echo $_SESSION['admin_full_name']; ?></p>
            <p class="text-sm text-gray-500"><?php echo $_SESSION['admin_role']; ?></p>
          </div>
        </div>
        <a href="logout.php" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors mt-2">
          <span class="material-symbols-outlined">logout</span>Logout
        </a>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8 overflow-y-auto">
    <div class="flex items-center mb-8">
      <a class="text-gray-500 hover:text-[var(--primary-color)] transition-colors" href="users.php">
        <span class="material-symbols-outlined text-3xl">arrow_back_ios_new</span>
      </a>
      <h2 class="text-4xl font-bold text-gray-800 ml-4">Edit User</h2>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 max-w-4xl mx-auto">

      <?php if(!empty($success)): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $success; ?></div>
      <?php endif; ?>
      <?php if(!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
          <ul class="list-disc pl-5">
            <?php foreach($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="md:col-span-2">
            <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="full-name" name="full-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" value="<?php echo htmlspecialchars($user['full_name']); ?>"/>
          </div>

          <div class="md:col-span-2">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" value="<?php echo htmlspecialchars($user['email']); ?>"/>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm"/>
            <p class="text-gray-500 text-sm">Leave blank to keep current password.</p>
          </div>

          <div>
            <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm"/>
          </div>

          <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
              <option value="super_admin" <?php echo $user['role'] === 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
              <option value="staff" <?php echo $user['role'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
              <option value="manager" <?php echo $user['role'] === 'manager' ? 'selected' : ''; ?>>Manager</option>
            </select>
          </div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
          <a href="users.php" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
          <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] flex items-center gap-2">
            <span class="material-symbols-outlined">edit</span> Update User
          </button>
        </div>
      </form>
    </div>
  </main>
</div>
</body>
</html>
