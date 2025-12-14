<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM transactions WHERE transaction_id = $id";
$result = mysqli_query($conn, $sql);
$transaction = mysqli_fetch_assoc($result);

$accounts_sql = "SELECT account_id, account_number FROM accounts";
$accounts_result = mysqli_query($conn, $accounts_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="../home.php">Home</a>
            <a href="../users/users.php">Users</a>
            <a href="../accounts/accounts.php">Accounts</a>
            <a href="transactions.php">Transactions</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Edit Transaction</h2>
            <form method="POST" action="update_transaction.php">
                <input type="hidden" name="transaction_id" value="<?php echo $transaction['transaction_id']; ?>">
                <div class="form-group">
                    <label>Account</label>
                    <select name="account_id" required>
                        <?php while ($account = mysqli_fetch_assoc($accounts_result)): ?>
                            <option value="<?php echo $account['account_id']; ?>" 
                                <?php echo ($account['account_id'] == $transaction['account_id']) ? 'selected' : ''; ?>>
                                <?php echo $account['account_number']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Transaction Type</label>
                    <select name="transaction_type" required>
                        <option value="Deposit" <?php echo ($transaction['transaction_type'] == 'Deposit') ? 'selected' : ''; ?>>Deposit</option>
                        <option value="Withdrawal" <?php echo ($transaction['transaction_type'] == 'Withdrawal') ? 'selected' : ''; ?>>Withdrawal</option>
                        <option value="Transfer" <?php echo ($transaction['transaction_type'] == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" value="<?php echo $transaction['amount']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?php echo $transaction['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Recipient Account</label>
                    <input type="text" name="recipient_account" value="<?php echo $transaction['recipient_account']; ?>">
                </div>
                <div class="form-group">
                    <label>Transaction Date</label>
                    <input type="datetime-local" name="transaction_date" value="<?php echo date('Y-m-d\TH:i', strtotime($transaction['transaction_date'])); ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Completed" <?php echo ($transaction['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="Pending" <?php echo ($transaction['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Transaction</button>
                <a href="transactions.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>