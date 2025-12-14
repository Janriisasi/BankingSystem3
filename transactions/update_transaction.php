<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_id = $_POST['transaction_id'];
    $account_id = $_POST['account_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $recipient_account = $_POST['recipient_account'];
    $transaction_date = $_POST['transaction_date'];
    $status = $_POST['status'];

    $sql = "UPDATE transactions SET account_id='$account_id', transaction_type='$transaction_type', 
            amount='$amount', description='$description', recipient_account='$recipient_account', 
            transaction_date='$transaction_date', status='$status' WHERE transaction_id=$transaction_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: transactions.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>