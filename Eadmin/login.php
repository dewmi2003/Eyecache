<?php
session_start();
require 'db_connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT id, full_name, email, password, role FROM admins WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_full_name'] = $admin['full_name'];
            $_SESSION['admin_role'] = $admin['role'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please enter both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-md w-96">
<h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>
<?php if($error): ?>
<p class="text-red-500 mb-4"><?= $error ?></p>
<?php endif; ?>
<form method="post">
    <input type="email" name="email" placeholder="Email" required class="w-full p-2 mb-4 border rounded"/>
    <input type="password" name="password" placeholder="Password" required class="w-full p-2 mb-4 border rounded"/>
    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">Login</button>
</form>
<p class="text-center text-sm text-gray-500 mt-4">To register <a href="register.php" class="text-blue-600 hover:underline">click here</a>.</p>
</div>
</body>
</html>
