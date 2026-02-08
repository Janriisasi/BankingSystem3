<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles specific to the educational search bar */
        .search-container {
            margin: 20px auto;
            text-align: center;
            padding: 20px;
            border-top: 1px solid #ccc;
        }
        .search-container input[type="text"] { 
            background: #333; 
            border: 2px solid #27ae60; 
            border-radius: 5px; 
            color: white; 
            padding: 10px; 
            width: 400px; 
        }
        .search-container button { 
            background: #27ae60; 
            border: none; 
            border-radius: 5px; 
            color: white; 
            padding: 10px 20px; 
            cursor: pointer; 
        }
        #output { margin-top: 20px; color: #333; font-weight: bold; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Simple Banking System</h2>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="users/users.php">Users</a>
            <a href="accounts/accounts.php">Accounts</a>
            <a href="transactions/transactions.php">Transactions</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-section">
            <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
            <p>Manage your banking operations from the dashboard below.</p>
        </div>

        <div class="search-container">
            <h3>For Java Script Injection Only</h3>
            <form id="searchForm">
                <input type="text" id="searchBar" placeholder="Search here...">
                <button type="submit">Search</button>
            </form>

            <div id="output">
                <p>You Queried: <span id="queryDisplay"></span></p>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>👥 Users</h3>
                <p>Manage all user accounts in the system</p>
                <a href="users/users.php" class="btn btn-primary">View Users</a>
            </div>
            
            <div class="dashboard-card">
                <h3>💳 Accounts</h3>
                <p>Manage bank accounts and balances</p>
                <a href="accounts/accounts.php" class="btn btn-success">View Accounts</a>
            </div>
            
            <div class="dashboard-card">
                <h3>💰 Transactions</h3>
                <p>View and manage all transactions</p>
                <a href="transactions/transactions.php" class="btn btn-warning">View Transactions</a>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchBar');
        const display = document.getElementById('queryDisplay');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const val = input.value;
            
            display.innerHTML = val; 
        });
    </script>
</body>
</html>