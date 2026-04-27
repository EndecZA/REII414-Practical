<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_name = $_POST['project_name'];
    $phase_name = $_POST['phase_name'];
    $manager_id = $_SESSION['user_id'];


    $stmt1 = mysqli_prepare($conn, "INSERT INTO projects (name, manager_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt1, "si", $p_name, $manager_id);
    mysqli_stmt_execute($stmt1);
    
    $project_id = mysqli_insert_id($conn);

    $stmt2 = mysqli_prepare($conn, "INSERT INTO phases (project_id, name) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt2, "is", $project_id, $phase_name);
    mysqli_stmt_execute($stmt2);

    header("Location: index.php"); 
    exit();
}
?>