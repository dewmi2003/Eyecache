<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once "db_connect.php";


if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']);
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT full_name, email, password, role FROM users_tba WHERE id = ?");
        $stmt->execute([$approve_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $stmt_insert = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt_insert->execute([$user['full_name'], $user['email'], $user['password'], $user['role']]);

            $stmt_delete = $pdo->prepare("DELETE FROM users_tba WHERE id = ?");
            $stmt_delete->execute([$approve_id]);
        }

        $pdo->commit();
        header("Location: users.php");
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error approving user: " . $e->getMessage();
        exit;
    }
}


if (isset($_GET['deny_id'])) {
    $deny_id = intval($_GET['deny_id']);
    try {
        $stmt_delete = $pdo->prepare("DELETE FROM users_tba WHERE id = ?");
        $stmt_delete->execute([$deny_id]);
        header("Location: users.php");
        exit;
    } catch (PDOException $e) {
        echo "Error denying user: " . $e->getMessage();
        exit;
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    try {
        $stmt_delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt_delete->execute([$delete_id]);
        header("Location: users.php");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting user: " . $e->getMessage();
        exit;
    }
}


try {
    $stmt_tba = $pdo->query("SELECT id, full_name, email, role FROM users_tba ORDER BY id DESC");
    $users_tba = $stmt_tba->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching awaiting approval users: " . $e->getMessage();
    exit;
}


try {
    $stmt_users = $pdo->query("SELECT id, full_name, email, role FROM users ORDER BY id DESC");
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching users: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Users</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
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

 
  <main class="flex-1 p-8 overflow-y-auto">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-4xl font-bold text-gray-800">Users Management</h2>
      <button onclick="window.location.href='add_user.php'" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
        <span class="material-symbols-outlined">add</span>Add New User
      </button>
    </div>

    
    <div class="mb-12">
      <h3 class="text-2xl font-semibold text-gray-700 mb-4">Awaiting Approval</h3>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-4 font-semibold">User</th>
              <th class="p-4 font-semibold">Email</th>
              <th class="p-4 font-semibold">Role Requested</th>
              <th class="p-4 font-semibold text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (!empty($users_tba)): ?>
              <?php foreach ($users_tba as $user): ?>
                <tr>
                  <td class="p-4"><?php echo htmlspecialchars($user['full_name']); ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($user['email']); ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($user['role']); ?></td>
                  <td class="p-4 text-center">
                    <a href="?approve_id=<?php echo $user['id']; ?>" class="text-green-500 hover:text-green-700 mx-1" title="Approve">
                      <span class="material-symbols-outlined">check_circle</span>
                    </a>
                    <a href="?deny_id=<?php echo $user['id']; ?>" class="text-red-500 hover:text-red-700 mx-1" title="Deny">
                      <span class="material-symbols-outlined">cancel</span>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">No users awaiting approval.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    
    <div>
      <h3 class="text-2xl font-semibold text-gray-700 mb-4">All Users</h3>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-4 font-semibold">User</th>
              <th class="p-4 font-semibold">Email</th>
              <th class="p-4 font-semibold">Role</th>
              <th class="p-4 font-semibold text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td class="p-4"><?php echo htmlspecialchars($user['full_name']); ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($user['email']); ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($user['role']); ?></td>
                  <td class="p-4 text-center">
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="text-blue-500 hover:text-blue-700 mx-1" title="Edit">
                      <span class="material-symbols-outlined">edit</span>
                    </a>
                    <a href="?delete_id=<?php echo $user['id']; ?>" class="text-red-500 hover:text-red-700 mx-1" title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                      <span class="material-symbols-outlined">delete</span>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">No users found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</div>
</body>
</html>
