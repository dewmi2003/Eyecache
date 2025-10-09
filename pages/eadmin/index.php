<?php
session_start();

// If admin is logged in, go to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: home.php");
    exit;
}

// Otherwise, go to login page
header("Location: login.php");
exit;
?>
