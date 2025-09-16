<?php
session_start();
require 'db_connect.php'; // contains your PDO or MySQL connection ($pdo)

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert into users_tba
        $stmt = $pdo->prepare("INSERT INTO users_tba (full_name, email, password, role) 
                               VALUES (:full_name, :email, :password, :role)");
        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);

        // Redirect after success
        header("Location: submitted.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<title>Admin Panel - Register</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
      :root {
        --primary-color: #1173d4;
      }
    </style>
</head>
<body class="bg-gray-50 font-sans">
<div class="relative flex min-h-screen w-full flex-col items-center justify-center bg-gray-50 group/design-root overflow-x-hidden">
<div class="flex w-full max-w-md flex-col gap-6 p-8">
<div class="flex flex-col items-center gap-4 text-center">
<div class="size-8 text-[var(--primary-color)]">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M42.4379 44C42.4379 44 36.0744 33.9038 41.1692 24C46.8624 12.9336 42.2078 4 42.2078 4L7.01134 4C7.01134 4 11.6577 12.932 5.96912 23.9969C0.876273 33.9029 7.27094 44 7.27094 44L42.4379 44Z" fill="currentColor"></path>
</svg>
</div>
<h1 class="text-2xl font-bold text-gray-900">Create your Admin Account</h1>
<p class="text-sm text-gray-600">Get started with our e-commerce platform</p>
</div>
<div class="w-full rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
<form class="flex flex-col gap-6" method="POST" action="register.php">
<div class="grid grid-cols-1 gap-6">
<label class="flex flex-col gap-1.5">
<p class="text-sm font-medium text-gray-700">Full Name</p>
<input class="form-input w-full rounded-md border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter your full name" type="text" name="full_name"/>
</label>
<label class="flex flex-col gap-1.5">
<p class="text-sm font-medium text-gray-700">Email</p>
<input class="form-input w-full rounded-md border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter your email" type="email" name="email"/>
</label>
<label class="flex flex-col gap-1.5">
<p class="text-sm font-medium text-gray-700">Password</p>
<input class="form-input w-full rounded-md border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter your password" type="password" name="password"/>
</label>
<label class="flex flex-col gap-1.5">
<p class="text-sm font-medium text-gray-700">Confirm Password</p>
<input class="form-input w-full rounded-md border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500" placeholder="Confirm your password" type="password" name="confirm_password"/>
</label>
<label class="flex flex-col gap-1.5">
<p class="text-sm font-medium text-gray-700">Role</p>
<select class="form-select w-full rounded-md border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" name="role">
<option disabled="" selected="" value="">Select Role</option>
<option value="super_admin">Super Admin</option>
<option value="manager">Manager</option>
<option value="staff">Staff</option>
</select>
</label>
</div>
<div class="mt-2 flex flex-col gap-4">
<button class="flex w-full cursor-pointer items-center justify-center rounded-md bg-[var(--primary-color)] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" type="submit">
                Register
              </button>
<button class="flex w-full cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2" type="button">
                Cancel
              </button>
</div>
</form>
</div>
<p class="text-center text-sm text-gray-600">
          Already have an account?
          <a class="font-medium text-[var(--primary-color)] hover:underline" href="login.php">Click here to login</a>
</p>
</div>
</div>

</body></html>