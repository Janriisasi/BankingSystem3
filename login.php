<?php
session_start();
include 'config/db.php';

/* prevent mysqli fatal error screen */
mysqli_report(MYSQLI_REPORT_OFF);

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    try {
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];

            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } catch (Exception $e) {
        // swallow SQL errors so page never crashes
        $error = "Login failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>

    <div class="auth-container">
        <div class="card">

            <h2>Login</h2>

            <!-- reflected XSS from POST -->
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <script>
                    var u = "<?php echo $_POST['username'] ?? ''; ?>";
                    document.write("You entered username: " + u + "<br>");
                </script>
            <?php endif; ?>

            <!-- error message vulnerable -->
            <?php if (isset($error)): ?>
                <script>
                    var errorMsg = "<?php echo $error; ?>";
                    document.write(errorMsg);
                </script>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary" id="loginBtn">Login</button>
                <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
            <div id="message"></div>

            <script>
                const userInput = document.getElementById("username");
                const passwordInput = document.getElementById("password");
                const usernameStatus = document.getElementById("usernameStatus");
                const passwordStatus = document.getElementById("passwordStatus");

                //DOM XSS (live reflection)
                userInput.addEventListener("input", function() {
                    usernameStatus.innerHTML = userInput.value; // intentionally unsafe
                });

                passwordInput.addEventListener("input", function() {
                    passwordStatus.innerHTML = passwordInput.value; // intentionally unsafe
                });

                //URL-based injection
                const params = new URLSearchParams(window.location.search);
                const msg = params.get("msg");

                if (msg) {
                    document.getElementById("message").innerHTML = msg; // intentionally unsafe
                }
            </script>
        </div>
    </div>
</body>
</html>