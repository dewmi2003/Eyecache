<?php
session_start();
include("Registerdb.php");
include("nav_bar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: EyecacheLogin.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $connection->prepare("SELECT user_id, full_name, email, address, city, postal_code, phone,password 
                              FROM userdetails 
                              WHERE user_id=?");
if (!$stmt) {
    die("Prepare failed: " . $connection->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows===0){
    die("No user found for User ID =" .$user_id);
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

  <!-- Google Font -->
  

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="navbar.css">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #111;
        color: #eee;
        margin: 0;
        padding: 100px 10%;
    }
    h2 {
        color: #ff3c78;
        margin-bottom: 20px;
    }
    .profile-details {
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #1b1b1b;
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
    .profile-details p strong {
        color: #ff3c78;
    }
    .profile-details p:last-child {
        border-bottom: none;
    }
    .update-btn {
        margin-top: 20px;
        padding: 12px;
        background: #ff3c78;
        border: none;
        border-radius: 6px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-block;
    }
    .update-btn:hover {
        background: #e62e63;
    }
</style>
</head>
<body>

<h2>User Profile</h2>
<div class="profile-details">
    <p><strong>User ID:</strong> <?= $user['user_id'] ?></p>
    <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
    <p><strong>City:</strong> <?= htmlspecialchars($user['city']) ?></p>
    <p><strong>Postal Code:</strong> <?= htmlspecialchars($user['postal_code']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
<p><strong>Password:</strong>
    <span aria-hidden="true">••••••••</span>
</p>

</div>

<a href="EyecacheRegister.php" class="update-btn">Update Profile</a>

</body>
</html>
