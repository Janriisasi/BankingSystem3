<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$sql = "SELECT a.*, u.full_name FROM accounts a 
        JOIN users u ON a.user_id = u.user_id 
        ORDER BY a.account_id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
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
            <h2>Manage Accounts</h2>
            <a href="add_account.php" class="btn btn-success">Add New Account</a>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Account Number</th>
                        <th>Owner</th>
                        <th>Type</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['account_id']; ?></td>
                        <td><?php echo $row['account_number']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['account_type']; ?></td>
                        <td>$<?php echo number_format($row['balance'], 2); ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['branch']; ?></td>
                        <td class="action-buttons">
                            <a href="edit_account.php?id=<?php echo $row['account_id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_account.php?id=<?php echo $row['account_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>