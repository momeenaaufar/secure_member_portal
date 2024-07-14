<?php
session_start();
include 'conn.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Fetch the current password from the database
    $stmt = $pdo->prepare('SELECT password FROM tbl_users WHERE userID = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // For demonstration purposes, compare passwords as plain text
    if ($user && $old_password === $user['password']) {
        // Update the password
        $stmt = $pdo->prepare('UPDATE tbl_users SET password = ? WHERE userID = ?');
        $stmt->execute([$new_password, $user_id]);

        header("Location: protected-home.php");
        exit;
    } else {
        $error = 'Old password is incorrect.';
    }
}
?>

<div class="container">
    <div class="password-form">
        <h1>Change Password</h1>
        <form method="post" class="password" action="account.php">
            <div>
                <label for="old_password">Old Password:</label>
                <input type="password" id="old_password" class="form-control" name="old_password" required>
            </div>
            <div>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" class="form-control" name="new_password" required>
            </div>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div>
                <button type="submit" class="button">Change Password</button>
            </div>
            <a href="protected-home.php" class="btn">Back to Dashboard</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
