<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$users_sql = "SELECT user_id, full_name FROM users";
$users_result = mysqli_query($conn, $users_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];
    $status = $_POST['status'];
    $branch = $_POST['branch'];

    $sql = "INSERT INTO accounts (user_id, account_number, account_type, balance, status, branch) 
            VALUES ('$user_id', '$account_number', '$account_type', '$balance', '$status', '$branch')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: accounts.php");
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
    <title>Add Account</title>
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
            <h2>Add New Account</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>User</label>
                    <select name="user_id" required>
                        <option value="">Select User</option>
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" name="account_number" required>
                </div>
                <div class="form-group">
                    <label>Account Type</label>
                    <select name="account_type" required>
                        <option value="Savings">Savings</option>
                        <option value="Checking">Checking</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input type="number" name="balance" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Branch</label>
                    <input type="text" name="branch" required>
                </div>
                <button type="submit" class="btn btn-success">Add Account</button>
                <a href="accounts.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>