<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../config/db.php';

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE user_id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: users.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>