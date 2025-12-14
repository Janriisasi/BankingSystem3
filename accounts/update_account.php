<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = $_POST['account_id'];
    $user_id = $_POST['user_id'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];
    $status = $_POST['status'];
    $branch = $_POST['branch'];

    $sql = "UPDATE accounts SET user_id='$user_id', account_number='$account_number', 
            account_type='$account_type', balance='$balance', status='$status', branch='$branch' 
            WHERE account_id=$account_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: accounts.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>