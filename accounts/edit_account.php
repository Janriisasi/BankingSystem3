<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM accounts WHERE account_id = $id";
$result = mysqli_query($conn, $sql);
$account = mysqli_fetch_assoc($result);

$users_sql = "SELECT user_id, full_name FROM users";
$users_result = mysqli_query($conn, $users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="../home.php">Home</a>
            <a href="../users/users.php">Users</a>
            <a href="accounts.php">Accounts</a>
            <a href="../transactions/transactions.php">Transactions</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Edit Account</h2>
            <form method="POST" action="update_account.php">
                <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
                <div class="form-group">
                    <label>User</label>
                    <select name="user_id" required>
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <option value="<?php echo $user['user_id']; ?>" 
                                <?php echo ($user['user_id'] == $account['user_id']) ? 'selected' : ''; ?>>
                                <?php echo $user['full_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" name="account_number" value="<?php echo $account['account_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Account Type</label>
                    <select name="account_type" required>
                        <option value="Savings" <?php echo ($account['account_type'] == 'Savings') ? 'selected' : ''; ?>>Savings</option>
                        <option value="Checking" <?php echo ($account['account_type'] == 'Checking') ? 'selected' : ''; ?>>Checking</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" name="balance" step="0.01" value="<?php echo $account['balance']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Active" <?php echo ($account['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo ($account['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Branch</label>
                    <input type="text" name="branch" value="<?php echo $account['branch']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Account</button>
                <a href="accounts.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>