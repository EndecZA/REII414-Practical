<?php
session_start();
include 'db.php';

// Security check: Only allow Managers or Admins to remove people from projects
if (!isset($_SESSION['user_title']) || ($_SESSION['user_title'] !== 'Manager' && $_SESSION['user_title'] !== 'Admin')) {
    die("Access Denied: Unauthorized action.");
}

if (isset($_GET['user_id']) && isset($_GET['project_id'])) {
    $user_id = intval($_GET['user_id']);
    $project_id = intval($_GET['project_id']);

    // Secure Deletion: Match the specific user and project combination to delete the row
    $stmt = mysqli_prepare($conn, "DELETE FROM project_assignments WHERE project_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $project_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Send them straight back to the settings tab for that project
        header("Location: projects.php?id=" . $project_id . "&tab=settings");
        exit();
    } else {
        echo "Error removing employee: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>