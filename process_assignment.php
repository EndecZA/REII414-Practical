<?php
session_start();
include 'db.php';

// Security check
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];
    $user_id = $_POST['user_id'];

    // Insert the relationship into the new table
    $stmt = mysqli_prepare($conn, "INSERT INTO project_assignments (project_id, user_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ii", $project_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: projects.php?tab=settings&status=success");
        exit();
    } else {
        echo "Error: Could not assign employee. They might already be assigned.";
    }
}
?>