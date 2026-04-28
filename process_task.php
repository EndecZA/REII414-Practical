<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $phase_id = $_POST['phase_id'];
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];       
    $deadline = $_POST['deadline'];
    $notes = $_POST['notes'];
    
    // File Upload Logic
    $target_file = "";
    if (!empty($_FILES["task_file"]["name"])) {
        $target_dir = "uploads/"; 
        $target_file = $target_dir . basename($_FILES["task_file"]["name"]);
        move_uploaded_file($_FILES["task_file"]["tmp_name"], $target_file);
    }

    
    $stmt = mysqli_prepare($conn, "INSERT INTO tasks (phase_id, title, deadline, notes, file_path) VALUES (?, ?, ?, ?, ?)");
    
    
    mysqli_stmt_bind_param($stmt, "issss", $phase_id, $title, $deadline, $notes, $target_file);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: projects.php?id=$project_id&tab=phases");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>