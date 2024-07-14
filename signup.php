<?php
session_start(); // Start the session

include 'conn.php'; // Connect to the database
include 'header.php'; // Include the header

// Initialize variables to store error messages and input values
$error = '';
$full_name = '';
$email = '';
$password = '';
$confirm_password = '';
$city = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $city = $_POST['city'];

    // Validate input
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($city)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if the email already exists
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM tbl_users WHERE email = ?');
        $stmt->execute([$email]);
        $email_exists = $stmt->fetchColumn();

        if ($email_exists) {
            $error = 'This email is already registered.';
        } else {
            // Insert the new user into the database
            // Note: Here we're inserting the plaintext password directly (NOT RECOMMENDED)
            $stmt = $pdo->prepare('INSERT INTO tbl_users (fullName, email, password, city) VALUES (?, ?, ?, ?)');
            $stmt->execute([$full_name, $email, $password, $city]);

            // Redirect to login page
            header('Location: login.php');
            exit;
        }
    }
}
?>

<div class="container">
    <div class="signin-form">
        <h1>Sign Up</h1>
        <form method="post" class="signin" action="signup.php">
            <div>
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" class="form-control" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password"  class="form-control" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
            </div>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div>
                <button type="submit" class="button">Sign Up</button>
                <a href="login.php" class="btn">Back to login</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>
