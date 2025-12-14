<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE user_id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="../home.php">Home</a>
            <a href="users.php">Users</a>
            <a href="../accounts/accounts.php">Accounts</a>
            <a href="../transactions/transactions.php">Transactions</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Edit User</h2>
            <form method="POST" action="update_user.php">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" required><?php echo $user['address']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="users.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>