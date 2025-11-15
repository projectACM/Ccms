<?php
require_once '../config/db.php';

// If user is logged in, redirect to dashboard
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

// If user is not logged in, redirect to login
header('Location: login.php');
exit;
?>
