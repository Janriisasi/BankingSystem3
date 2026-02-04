<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid username or password";
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
                    <small id="usernameStatus"></small>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                    <small id="passwordStatus"></small>
                </div>
                <button type="submit" class="btn btn-primary" id="loginBtn">Login</button>
                <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>

            <script>
                const userInput = document.getElementById("username");
                const passwordInput = document.getElementById("password");
                const loginBtn = document.getElementById("loginBtn");
                const usernameStatus = document.getElementById("usernameStatus");
                const passwordStatus = document.getElementById("passwordStatus");

                // Username input events
                userInput.addEventListener("focus", function () {
                    usernameStatus.innerHTML = "Username field is active";
                    usernameStatus.style.color = "green";
                });

                userInput.addEventListener("blur", function () {
                    if (userInput.value.length === 0) {
                        usernameStatus.innerHTML = "Username cannot be empty";
                        usernameStatus.style.color = "red";
                    } else {
                        usernameStatus.innerHTML = "Username: " + userInput.value;
                        usernameStatus.style.color = "green";
                    }
                });

                // Password input events
                passwordInput.addEventListener("focus", function () {
                    passwordStatus.innerHTML = "Password field is active";
                    passwordStatus.style.color = "green";
                });

                passwordInput.addEventListener("blur", function () {
                    if (passwordInput.value.length === 0) {
                        passwordStatus.innerHTML = "Password cannot be empty";
                        passwordStatus.style.color = "red";
                    } else {
                        passwordStatus.innerHTML = "Password length: " + passwordInput.value.length + " characters";
                        passwordStatus.style.color = "green";
                    }
                });

                // Button hover effects
                loginBtn.addEventListener("mouseover", function () {
                    loginBtn.style.transform = "scale(1.05)";
                    loginBtn.style.transition = "0.3s";
                });

                loginBtn.addEventListener("mouseout", function () {
                    loginBtn.style.transform = "scale(1)";
                });

                // Button click validation
                loginBtn.addEventListener("click", function (e) {
                    if (userInput.value === "" || passwordInput.value === "") {
                        alert("Please fill in all fields!");
                        e.preventDefault();
                    } else {
                        alert("Attempting to login as: " + userInput.value);
                    }
                });

                // Function to display live console preview
                function displayConsolePreview() {
                    console.clear();
                    console.log("Username: " + userInput.value);
                    console.log("Password: " + passwordInput.value);
                }

                userInput.addEventListener("input", function () {
                    displayConsolePreview();
                });

                passwordInput.addEventListener("input", function () {
                    displayConsolePreview();
                });
            </script>
            <div id="message"></div>

            <script>
                const params = new URLSearchParams(window.location.search);
                const msg = params.get("msg");

                if (msg) {
                    document.getElementById("message").innerHTML = msg;
                }
            </script>
        </div>
    </div>
</body>
</html>