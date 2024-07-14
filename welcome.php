<?php
session_start(); // Start the session to check login status
include 'conn.php';
include 'header.php'; // Include header

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    header("Location: protected-home.php"); // Redirect logged-in users to the protected home page
    exit;
}
?>

<div class="container">
    <div class="welcome">
        <h1>Welcome to Our Secure Member Portal</h1>
        <img src="logos/Congratulation.png" alt="welcome image">
        <p>Please log in to access your account.</p>
        <a href="login.php" class="btn">Login</a> <!-- Link to the login page -->
    </div>
</div>

<?php include 'footer.php'; // Include footer ?>



