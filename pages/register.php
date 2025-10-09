<?php 
session_start();
include("../includes/db_connect.php"); // make sure this defines $connection
// No need to include nav_bar.php before PHP processing if redirecting

$message = "";
$registration_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $city = trim($_POST["city"]);
    $postal_code = trim($_POST["postal_code"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"]; // student or admin

    // Validate passwords
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($role === "student") {
            // Student auto-approved
            $stmt = $conn->prepare(
                "INSERT INTO users (full_name, email, address, city, postal_code, phone, password, role, is_approved) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)"
            );
            if (!$stmt) { die("Prepare failed: " . $conn->error); }
            $stmt->bind_param("ssssssss", $full_name, $email, $address, $city, $postal_code, $phone, $hashed_password, $role);
        } else {
            // Admin pending approval (default is 0)
            $stmt = $conn->prepare(
                "INSERT INTO users (full_name, email, address, city, postal_code, phone, password, role) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            if (!$stmt) { die("Prepare failed: " . $conn->error); }
            $stmt->bind_param("ssssssss", $full_name, $email, $address, $city, $postal_code, $phone, $hashed_password, $role);
        }

        if ($stmt->execute()) {
            $registration_success = true;

            // Redirect based on role
            if ($role === "student") {
                header("Location: login.php");
            } else {
                header("Location: eadmin/submitted.php");
            }
            exit;
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register-EyeCache</title>
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">


<link href="/assets/css/lm.css" rel="stylesheet"/>
<style>
    /* Navbar */
        .navbar.fixed-top {
            background-color: var(--base-variant) ;
            padding: 1rem 2rem;
            box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2);
            z-index: 1000;
        }

        .navbar-brand {
            color: #FF2B68 !important;
            font-weight: bold;
            font-size: 2rem;
            transition: transform 0.3s;
        }

        .navbar-brand:hover {
            transform: scale(1.1);
            color: #ff4c80 !important;
        }

        .navbar-nav .nav-link {
            color: #FF2B68 !important;
            font-weight: 600;
            margin-left: 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s, transform 0.3s;
        }

        .navbar-nav .nav-link i {
            font-size: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #ff4c80 !important;
            transform: translateY(-2px);
        }
* { box-sizing: border-box; margin:0; padding:0; }
body { padding: 120px 5% 50px 5%; background: var(--base-variant); color: var(--secondary-text); }
.register-container {
    background:var(--base-variant); margin:80px auto; padding:40px 30px; border-radius:12px;
    width:100%; max-width:800px; box-shadow: 0 5px 25px rgba(0,0,0,0.5); text-align: left; color:var(--secondary-text);
}
.register-container h2 { text-align:left; margin-bottom:25px; color:#ff3c78; }
.register-container label { display:block; margin-top:15px; font-weight:600; }
.register-container input, .register-container select {
    width:100%; padding:12px; margin-top:5px; border-radius:6px; border:1px solid #333; background:var(--base-variant); color:var(--secondary-text);
}
.register-container input:focus, .register-container select:focus { outline:none; border-color:#ff3c78; }
.register-container button {
    width:100%; padding:12px; margin-top:25px; background:#ff3c78; border:none; border-radius:6px; color:white;
    font-size:16px; cursor:pointer; transition:0.3s; text-align:center;
}
.register-container button:hover { background:#e62e63; }
.register-container .message { margin-top:15px; text-align:left; color:#ff3c78; }
.register-container .link { text-align:center; margin-top:20px; }
.register-container .link a { color:#ff3c78; font-weight:600; text-decoration:none; }
.register-container .link a:hover { color:#e62e63; }

@media (min-width: 768px) {
    .form-row { display:flex; gap:20px; }
    .form-row > div { flex:1; }    
}
</style>
    <link href="/assets/css/theme.css" rel="stylesheet"/>
</head>

<body>
<?php include '../includes/navbar.php'; ?>

<div class="register-container">
    <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <h2>Register to EyeCache</h2>

    <form method="post">
        <div class="form-row">
            <div>
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" placeholder="Your full name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Your email" required>
            </div>
        </div>

        <label for="address">Street Address</label>
        <input type="text" name="address" id="address" placeholder="Street address" required>

        <div class="form-row">
            <div>
                <label for="city">City</label>
                <input type="text" name="city" id="city" placeholder="City" required>
            </div>
            <div>
                <label for="postal_code">Postal Code</label>
                <input type="text" name="postal_code" id="postal_code" placeholder="Postal/Zip code" required>
            </div>
        </div>

        <label for="phone">Telephone Number</label>
        <input type="text" name="phone" id="phone" placeholder="Phone number" required>

        <div class="form-row">
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
            </div>
        </div>

        <label for="role">Register As</label>
        <select name="role" id="role" required>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
        <div class="link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

<footer>
    &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>
    <script src="/assets/js/lm.js">
  
</script>
</body>
</html>
