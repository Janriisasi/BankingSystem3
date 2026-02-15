<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // SQL injection intentionally possible
    $sql = "INSERT INTO users (username, password, full_name, email, phone, address)
            VALUES ('$username', '$password', '$full_name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
        </div>
    </div>

    <div class="auth-container">
        <div class="card">
            <h2>Sign Up</h2>
            <!-- reflected POST XSS -->
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <script>
                    document.write("Registered username: <?php echo $_POST['username'] ?? ''; ?><br>");
                </script>
            <?php endif; ?>

            <!-- error vulnerable -->
            <?php if (isset($error)): ?>
                <div><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" id="signupForm">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
                <p class="signup-link">Already have an account? <a href="login.php">Login</a></p>
            </form>

            <script>
                //DOM XSS: reflects all inputs on submit
                document.getElementById("signupForm").addEventListener("submit", function() {
                    const inputs = document.querySelectorAll("input, textarea");
                    inputs.forEach(i => {
                        document.body.innerHTML += "<p>" + i.value + "</p>"; // unsafe
                    });
                });

                //URL injection
                const params = new URLSearchParams(window.location.search);
                const msg = params.get("msg");
                if (msg) {
                    document.body.innerHTML += msg; // unsafe
                }
            </script>
        </div>
    </div>
</body>
</html>