<?php
session_start();
include 'db.php';

// Security Check
if (!isset($_SESSION['user_title']) || ($_SESSION['user_title'] !== 'Manager' && $_SESSION['user_title'] !== 'Admin')) {
    die("Access Denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = intval($_POST['project_id']);
    $phase_name = $_POST['phase_name'];

    if ($project_id > 0 && !empty($phase_name)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO phases (project_id, name) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "is", $project_id, $phase_name);
        
        if (mysqli_stmt_execute($stmt)) {
            // Send them back to the projects page on the PHASES tab with this project selected
            header("Location: projects.php?id=" . $project_id . "&tab=phases");
            exit();
        } else {
            echo "Error: Could not add phase. " . mysqli_error($conn);
        }
    } else {
        echo "Please complete all fields required.";
    }
}
?>