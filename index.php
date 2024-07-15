<?php
session_start();
include 'conn.php'; 
include 'header.php'; 
include 'footer.php';

if (isset($_SESSION['user_id'])) {
    header("Location: protected-home.php");
    exit;
} else {
    header("Location: welcome.php");
    exit;
}

