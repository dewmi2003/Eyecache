<?php
session_start();
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        
        $stmt = $pdo->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = :email OR full_name = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_full_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Invalid email/full name or password.";
        }
    } else {
        $error = "Please enter both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta charset="utf-8"/>
<title>Login Page</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
      :root {
        --primary-50: #eff6ff;
        --primary-100: #dbeafe;
        --primary-200: #bfdbfe;
        --primary-300: #93c5fd;
        --primary-400: #60a5fa;
        --primary-500: #3b82f6;
        --primary-600: #2563eb;
        --primary-700: #1d4ed8;
        --primary-800: #1e40af;
        --primary-900: #1e3a8a;
        --primary-950: #172554;
      }
      body {
        font-family: 'Inter', sans-serif;
      }
    </style>
</head>
<body class="bg-gray-50 antialiased">
<div class="relative flex min-h-screen w-full flex-col items-center justify-center bg-gray-50 group/design-root overflow-x-hidden">
<div class="flex w-full max-w-md flex-col items-center space-y-8 px-4 py-12">
<div class="flex items-center gap-3 text-gray-800">
<div class="h-8 w-8 text-[var(--primary-600)]">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_6_319)">
<path d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z" fill="currentColor"></path>
</g>
<defs>
<clipPath id="clip0_6_319">
<rect fill="white" height="48" width="48"></rect>
</clipPath>
</defs>
</svg>
</div>
<h1 class="text-2xl font-bold tracking-tight text-gray-900">Store Admin</h1>
</div>
<div class="w-full rounded-lg border border-gray-200 bg-white shadow-sm">
<div class="p-8">
<div class="space-y-6">
<div class="text-center">
<h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
<p class="mt-2 text-sm text-gray-500">Log in to manage your store</p>
</div>
<form class="space-y-6" action="login.php" method="POST">
<div>
<label class="block text-sm font-medium text-gray-700" for="email">Email or username</label>
<div class="mt-1">
<input autocomplete="email" class="block w-full appearance-none rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[var(--primary-500)] focus:outline-none focus:ring-[var(--primary-500)] sm:text-sm" id="email" name="email" placeholder="you@example.com" required="" type="email"/>
</div>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="password">Password</label>
<div class="mt-1">
<input autocomplete="current-password" class="block w-full appearance-none rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-[var(--primary-500)] focus:outline-none focus:ring-[var(--primary-500)] sm:text-sm" id="password" name="password" placeholder="••••••••" required="" type="password"/>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<input class="h-4 w-4 rounded border-gray-300 text-[var(--primary-600)] focus:ring-[var(--primary-500)]" id="remember-me" name="remember-me" type="checkbox"/>
<label class="ml-2 block text-sm text-gray-900" for="remember-me">Remember me</label>
</div>
<div class="text-sm">
<a class="font-medium text-[var(--primary-600)] hover:text-[var(--primary-500)]" href="#">Forgot password?</a>
</div>
</div>
<div>
<button class="flex w-full justify-center rounded-md border border-transparent bg-[var(--primary-600)] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[var(--primary-700)] focus:outline-none focus:ring-2 focus:ring-[var(--primary-500)] focus:ring-offset-2" type="submit">Log in</button>
</div>
</form>
<p class="text-center text-sm text-gray-500">To register <a class="font-medium text-[var(--primary-600)] hover:text-[var(--primary-700)]" href="register.php">click here.</a></p>
</div>
</div>
</div>
</div>
</div>

</body></html>


