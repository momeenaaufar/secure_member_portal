<?php
session_start(); 
include 'conn.php';
include 'header.php'; 


if (isset($_SESSION['user_id'])) {
    header("Location: protected-home.php"); 
    exit;
}
?>
<div class="container">
    <div class="welcome-container">
        <div class="welcome">
                <h1>Welcome to Our Secure Member Portal</h1>
                <div class="content">
                        <p class="para">Our Secure Member Portal provides a safe and convenient way for our members to access exclusive content, manage their profiles, and stay updated with the latest information. Enjoy seamless access to personalized services and features designed to enhance your experience. Log in to explore:
                            Personalized Dashboard: View and manage your account details.
                            Profile Management: Update your personal information with ease.
                            Secure Access: Your data is protected with industry-standard security measures.
                            Exclusive Content: Access members-only resources and updates.
                            Join us today and take advantage of all the benefits our secure member portal has to offer!
                        </p>
                        <img src="logos/Congratulation.png" alt="welcome image">
                </div>
                <p>Please log in to access your account.</p>
                <a href="login.php" class="btn">Login</a> 
        </div>
    </div>
</div>

<?php include 'footer.php'; // Include footer ?>



