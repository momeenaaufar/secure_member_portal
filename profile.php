<?php
session_start();
include 'conn.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare('SELECT email, fullName, city FROM tbl_users WHERE userID = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $city = $_POST['city'];

    $stmt = $pdo->prepare('UPDATE tbl_users SET email = ?, fullName = ?, city = ? WHERE UserID = ?');
    $stmt->execute([$email, $full_name, $city, $user_id]);

    header("Location: protected-home.php");
    exit;
}
?>

<div class="container">
    <div class="profile-form">
        <h1>Update Profile</h1>
        <form method="post" class="profile" action="profile.php">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div>
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['fullName']); ?>" required>
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" id="city"  class="form-control" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
            </div>
            <div>
                <button type="submit" class="button">Update</button>
            </div>
            <a href="protected-home.php" class="btn">Back to Dashboard</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
