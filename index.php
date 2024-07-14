<?php
session_start();
include 'conn.php'; // Connect to the database
include 'header.php'; // Include header
include 'footer.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to the dashboard
    header("Location: protected-home.php");
    exit;
} else {
    // User is not logged in, redirect to welcome page
    header("Location: welcome.php");
    exit;
}

