<?php
session_start();
if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'admin') {
    die("Access Denied.");
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_POST['user_id'];
    $title = $_POST['new_title'];
     
    $stmt = mysqli_prepare($conn, "UPDATE users SET title = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $title, $uid);
    mysqli_stmt_execute($stmt);
    
    header("Location: admin_users.php");
    exit();
}
?>