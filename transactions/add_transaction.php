<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$accounts_sql = "SELECT account_id, account_number FROM accounts";
$accounts_result = mysqli_query($conn, $accounts_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = $_POST['account_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $recipient_account = $_POST['recipient_account'];
    $transaction_date = $_POST['transaction_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO transactions (account_id, transaction_type, amount, description, recipient_account, transaction_date, status) 
            VALUES ('$account_id', '$transaction_type', '$amount', '$description', '$recipient_account', '$transaction_date', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: transactions.php");
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
    <title>Add Transaction</title>
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
            <a href="../logout.php"></a>
			<div class="container">
    <div class="card">
        <h2>Add New Transaction</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Account</label>
                <select name="account_id" required>
                    <option value="">Select Account</option>
                    <?php while ($account = mysqli_fetch_assoc($accounts_result)): ?>
                        <option value="<?php echo $account['account_id']; ?>"><?php echo $account['account_number']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Transaction Type</label>
                <select name="transaction_type" required>
                    <option value="Deposit">Deposit</option>
                    <option value="Withdrawal">Withdrawal</option>
                    <option value="Transfer">Transfer</option>
                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="number" name="amount" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Recipient Account (for transfers)</label>
                <input type="text" name="recipient_account">
            </div>
            <div class="form-group">
                <label>Transaction Date</label>
                <input type="datetime-local" name="transaction_date" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add Transaction</button>
            <a href="transactions.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>