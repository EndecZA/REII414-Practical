<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = intval($_POST['task_id']);
    $new_status = $_POST['status'];
    $redirect_to = $_POST['redirect_to'];

    // Confirm that the status value is one of our strict allowed ENUM types
    $allowed_statuses = ['not started', 'busy', 'completed'];
    if (in_array($new_status, $allowed_statuses) && $task_id > 0) {
        
        // Securely update the task status field
        $stmt = mysqli_prepare($conn, "UPDATE tasks SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_status, $task_id);
        mysqli_stmt_execute($stmt);
    }
    
    // Bounce back dynamically to whichever page initiated the action
    header("Location: " . $redirect_to);
    exit();
}
?>