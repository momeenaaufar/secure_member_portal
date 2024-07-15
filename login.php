<?php
session_start(); 

include 'conn.php';
include 'header.php'; 


$error = '';
$email = '';
$password = '';
$remember_me = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);


    if (empty($email) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        
        $stmt = $pdo->prepare('SELECT userID, password FROM tbl_users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) { 
            
            $_SESSION['user_id'] = $user['userID'];

           
            if ($remember_me) {
                setcookie('user_id', $user['userID'], time() + (86400 * 30), "/"); // Set cookie for 30 days
            }

            header('Location: protected-home.php'); 
            exit;
        } else {
            
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
        <p>New user? <a href="signup.php" class="button">Sign up</a></p>
    </div>
</div>

<?php include 'footer.php';  ?>
