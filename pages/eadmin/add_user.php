<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../includes/db_connect.php";

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $full_name = trim($_POST['full-name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = $_POST['role'];

    // Basic validation
    if (empty($full_name)) $errors[] = "Full Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($password)) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($role)) $errors[] = "Role is required.";

    // If no errors, insert into users table
    if (empty($errors)) {
        try {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $password_hash, $role]);

            $success = "User added successfully!";
        } catch (PDOException $e) {
            $errors[] = "Error adding user: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel - Add User</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <!-- Tailwind dark mode config -->
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

  <!-- Google Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

  <style>
    :root {
      --primary-color: #1173d4;
      --primary-hover-color: #0e5aab;
    }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">
<div class="flex h-screen">

<!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

<main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">
    <div class="flex items-center mb-8 justify-between">
        <div class="flex items-center">
            <a class="text-gray-500 dark:text-gray-300 hover:text-[var(--primary-color)] transition-colors" href="users.php">
                <span class="material-symbols-outlined text-3xl">arrow_back_ios_new</span>
            </a>
            <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100 ml-4">Add New User</h2>
        </div>
        <!-- Dark/Light Mode Toggle Button -->
       
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 max-w-4xl mx-auto transition-colors">
        <!-- Display success/error messages -->
        <?php if(!empty($success)): ?>
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 p-4 rounded mb-4"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if(!empty($errors)): ?>
            <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 p-4 rounded mb-4">
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
                    <label for="full-name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Full Name</label>
                    <input type="text" id="full-name" name="full-name" placeholder="John Doe" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
                           value="<?php echo isset($_POST['full-name']) ? htmlspecialchars($_POST['full-name']) : ''; ?>"/>
                </div>

                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="john.doe@example.com" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"/>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                    <input type="password" id="password" name="password" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm"/>
                </div>

                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm"/>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                    <select id="role" name="role" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] dark:bg-gray-900 dark:text-gray-100 sm:text-sm">
                        <option>super_admin</option>
                        <option>staff</option>
                        <option>manager</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="users.php" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
                <button type="submit" 
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] flex items-center gap-2">
                    <span class="material-symbols-outlined">person_add</span> Add User
                </button>
            </div>
        </form>
    </div>
</main>
</div>

<!-- Dark Mode Toggle Script -->


</body>
</html>