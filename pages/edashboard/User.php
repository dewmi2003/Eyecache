<?php
    
session_start();
include("../../includes/db_connect.php");
include("../../includes/navbar.php");
// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['student'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['student'];

// Fetch user details
$stmt = $conn->prepare("SELECT id, full_name, email, address, city, postal_code, phone 
                              FROM users
                              WHERE id=?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    die("No user found for User ID = " .$user_id);
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Profile</title>
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
body {
    font-family: 'Poppins', sans-serif;
    background: var(--base-variant);
    color: var(--secondary-text);
    margin: 0;
    padding: 100px 10%;
}
h2 { color: #ff3c78; margin-bottom: 20px; }
.profile-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: var(--base-variant);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.6);
    max-width:100%;
}
.profile-details p {
    margin: 0;
    font-size: 1rem;
    padding-bottom: 8px;
    border-bottom: 1px solid #333;
}
.profile-details p strong { color: #ff3c78; }
.profile-details p:last-child { border-bottom: none; }

.button-group {
    margin-top: 20px;
    display: flex;
    gap: 15px;
}

.btn {
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
}

.update-btn { background: #ff3c78; }
.update-btn:hover { background: #e62e63; }

.logout-btn { background: #555; }
.logout-btn:hover { background: #777; }
</style>
    <link href="../../assets/css/theme.css" rel="stylesheet"/>
</head>
<body>

<h2>User Profile</h2>
<div class="profile-details">
    <p><strong>User ID:</strong> <?= $user['id'] ?></p>
    <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
    <p><strong>City:</strong> <?= htmlspecialchars($user['city']) ?></p>
    <p><strong>Postal Code:</strong> <?= htmlspecialchars($user['postal_code']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Password:</strong> <span aria-hidden="true">••••••••</span></p>
</div>

<div class="button-group">
    <a href="../register.php" class="btn update-btn">Update Profile</a>
    <a href="?logout=true" class="btn logout-btn">Logout</a>
</div>
<script src="/assets/js/lm.js">
  
</script>
</body>
</html>
