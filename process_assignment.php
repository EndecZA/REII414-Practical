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
		$p_info = mysqli_query($conn, "SELECT name FROM projects WHERE id = " . intval($project_id));
		$p_row = mysqli_fetch_assoc($p_info);
		$project_name = $p_row['name'];

		$notif_msg = "You have been assigned to a new project: " . $project_name;
		$notif_stmt = mysqli_prepare($conn, "INSERT INTO notifications (user_id, project_id, message, type) VALUES (?, ?, ?, 'assignment')");
		mysqli_stmt_bind_param($notif_stmt, "iis", $user_id, $project_id, $notif_msg);
		mysqli_stmt_execute($notif_stmt);
        header("Location: projects.php?tab=settings&status=success");
        exit();
    } else {
        echo "Error: Could not assign employee. They might already be assigned.";
    }
}
?>