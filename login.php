<?php
session_start(); // Start the session

include 'conn.php'; // Connect to the database
include 'header.php'; // Include the header

// Initialize variables to store error messages and input values
$error = '';
$email = '';
$password = '';
$remember_me = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        // Prepare and execute a query to check the user's credentials
        $stmt = $pdo->prepare('SELECT userID, password FROM tbl_users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) { // Check plain text password
            // Successful login
            $_SESSION['user_id'] = $user['userID'];

            // Handle "Remember Me" functionality
            if ($remember_me) {
                setcookie('user_id', $user['userID'], time() + (86400 * 30), "/"); // Set cookie for 30 days
            }

            header('Location: protected-home.php'); // Redirect to protected home page
            exit;
        } else {
            // Invalid credentials
            $error = 'Invalid email or password.';
        }
    }
}
?>

<div class="container">
    <div class="login-form">
        <h1>Login</h1>
        <form method="post" class="login" action="login.php">
            <input type="hidden" name="login" value="1">
            <div>
                <label class="label" name="email">Email:</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div>
                <label class="label" for="password">Password:</label>
                <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <div>
                <label class="label" for="remember_me">
                    <input type="checkbox" id="remember_me" name="remember_me" <?php echo $remember_me ? 'checked' : ''; ?>>
                    Remember Me
                </label>
            </div>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div>
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
        <p>New user? <a href="signup.php">Sign up here</a></p>
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>
