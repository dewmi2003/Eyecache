<?php
session_start();
include("Registerdb.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $connection->prepare("SELECT user_id, password FROM userdetails WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "No account found with this email. Please register first.";
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: User.php");
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
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="navbar.css">
    <style>
    * {
        box-sizing: border-box;
        margin: 0; padding: 0;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: #111;
        color: #eee;
        padding: 120px 5% 50px 5%;
    }
    .login-container {
        width: 350px;
        margin: 80px auto;
        padding: 30px;
        background: #1a1a1a;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        color: #eee;
    }
    .login-container h1 {
        text-align: center;
        margin-bottom: 25px;
        color: #ff3c78;
    }
    .login-container label {
        display: block;
        margin-top: 15px;
        font-weight: 600;
    }
    .login-container input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #333;
        border-radius: 6px;
        background: #111;
        color: #eee;
    }
    .login-container input:focus {
        outline: none;
        border-color: #ff3c78;
    }
    .login-container button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background: #ff3c78;
        border: none;
        border-radius: 6px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .login-container button:hover {
        background: #e62e63;
    }
    .login-container .link {
        text-align: center;
        margin-top: 15px;
    }
    .login-container .link a {
        color: #ff3c78;
        font-weight: 600;
    }
    .login-container .link a:hover {
        color: #e62e63;
    }
    footer {
        text-align: center;
        margin-top: 50px;
        padding: 15px 0;
        background: #222;
        border-top: 1px solid #333;
        color: #ccc;
    }
    </style>
</head>
<body>
    <?php include("nav_bar.php");?>

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
            <p>New to our store? Join now <a href="EyeCacheRegister.php">Register here</a></p>
        </div>
    </div>

    <footer>
        &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
    </footer>
</body>
</html>
