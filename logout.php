<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the welcome page or any other desired page
header("Location: index.php");
exit;

