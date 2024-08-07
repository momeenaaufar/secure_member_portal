<?php
session_start(); 

include 'conn.php'; 
include 'header.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}
?>

<div class="container">
    <div class="home">
        <h1>Welcome to Dashboard</h1>
        <ul class="dashboard-list">
            <a href="profile.php" class="btn"><i class="fas fa-user"></i>Update Profile</a>
            <a href="account.php" class="btn"><i class="fas fa-lock"></i>Change Password</a>
            <a href="holiday.php" class="btn"><i class="fas fa-calendar-alt"></i>View Public Holidays</a>
            <a href="logout.php" class="btn" onclick="return confirm('Are you sure you want to logout?');"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
