<?php
session_start();        // start the session
session_unset();        // remove all session variables
session_destroy();      // destroy the session

// Redirect back to login page
header("Location: login.php");
exit;
