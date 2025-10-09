<?php
session_start();
include '../includes/db_connect.php'; // Make sure $conn is your mysqli connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user from 'users' table
    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "No account found with this email. Please register first.";
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session variables based on role
            if ($row['role'] === 'admin') {
                $_SESSION['admin'] = $row['id'];
                $_SESSION['role'] = 'admin';
                $_SESSION['full_name'] = $row['full_name'];
                header("Location: eadmin/home.php");
            } elseif ($row['role'] === 'student') {
                $_SESSION['student'] = (int)$row['id'];
                $_SESSION['role'] = 'student';
                $_SESSION['full_name'] = $row['full_name'];
                header("Location: edashboard/User.php");
            } else {
                $message = "Invalid role assigned to account.";
                session_unset();
                session_destroy();
            }
            exit;
        } else {
            $message = "Incorrect password.";
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Custom CSS -->
<link href="/assets/css/lm.css" rel="stylesheet"/>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Poppins', sans-serif;
    background: var(--base-color);
    color: var(--secondary-text);
    padding: 120px 5% 50px 5%;
}
.navbar.fixed-top {
    background-color: var(--base-variant);
    padding: 1rem 2rem;
    box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2);
    z-index: 1000;
}
.navbar-brand { color: #FF2B68 !important; font-weight: bold; font-size: 2rem; transition: transform 0.3s; }
.navbar-brand:hover { transform: scale(1.1); color: #ff4c80 !important; }
.navbar-nav .nav-link {
    color: #FF2B68 !important; font-weight: 600; margin-left: 1rem;
    display: flex; align-items: center; gap: 6px;
    transition: color 0.3s, transform 0.3s;
}
.navbar-nav .nav-link i { font-size: 1rem; }
.navbar-nav .nav-link:hover { color: #ff4c80 !important; transform: translateY(-2px); }

.login-container {
    width: 350px; margin: 80px auto; padding: 30px;
    background: var(--base-variant); border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.5); color: var(--secondary-text);
}
.login-container h1 { text-align: center; margin-bottom: 25px; color: #ff3c78; }
.login-container label { display: block; margin-top: 15px; font-weight: 600; }
.login-container input {
    width: 100%; padding: 10px; margin-top: 5px;
    border: 1px solid var(--base-variant); border-radius: 6px;
    background: var(--base-variant); color: var(--secondary-text);
}
.login-container input:focus { outline: none; border-color: #ff3c78; }
.login-container button {
    width: 100%; padding: 12px; margin-top: 20px;
    background: #ff3c78; border: none; border-radius: 6px;
    color: #fff; font-size: 16px; cursor: pointer; transition: background 0.3s ease;
}
.login-container button:hover { background: #e62e63; }
.login-container .link { text-align: center; margin-top: 15px; }
.login-container .link a { color: #ff3c78; font-weight: 600; }
.login-container .link a:hover { color: #e62e63; }
footer {
    text-align: center; margin-top: 50px; padding: 15px 0;
    background: var(--base-variant); border-top: 1px solid #333; color: #ccc;
}
</style>
<link href="/assets/css/theme.css" rel="stylesheet"/>
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<div class="login-container">
    <h1>Login</h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>

    <div class="link">
        <p>New to our store? Join now <a href="/pages/register.php">Register here</a></p>
    </div>
</div>

<footer>
    &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>

<script src="/assets/js/lm.js"></script>
</body>
</html>
