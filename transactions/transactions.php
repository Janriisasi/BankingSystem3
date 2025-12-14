<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$sql = "SELECT t.*, a.account_number FROM transactions t 
        JOIN accounts a ON t.account_id = a.account_id 
        ORDER BY t.transaction_id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Transactions</title>
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
            <h2>Manage Transactions</h2>
            <a href="add_transaction.php" class="btn btn-success">Add New Transaction</a>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Account</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Recipient</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['transaction_id']; ?></td>
                        <td><?php echo $row['account_number']; ?></td>
                        <td><?php echo $row['transaction_type']; ?></td>
                        <td>$<?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['recipient_account'] ? $row['recipient_account'] : 'N/A'; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($row['transaction_date'])); ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td class="action-buttons">
                            <a href="edit_transaction.php?id=<?php echo $row['transaction_id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_transaction.php?id=<?php echo $row['transaction_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>