<?php
session_start();
include 'db.php';

if (isset($_GET['notif_id'])) {
    $notif_id = intval($_GET['notif_id']);
    
	$user_id = 0;
	if (isset($_SESSION['user_id'])) {
        $user_id = intval($_SESSION['user_id']);
    } elseif (isset($_SESSION['id'])) {
        $user_id = intval($_SESSION['id']);
    }
	
	$find_stmt = mysqli_prepare($conn, "SELECT task_id FROM notifications WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($find_stmt, "ii", $notif_id, $user_id);
    mysqli_stmt_execute($find_stmt);
    $res = mysqli_stmt_get_result($find_stmt);
    
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['task_id'])) {
            // Initialize session array tracker if it doesn't exist
            if (!isset($_SESSION['cleared_tasks'])) {
                $_SESSION['cleared_tasks'] = array();
            }
            // Add this task ID to our session memory array of dismissed alerts
            $_SESSION['cleared_tasks'][] = intval($row['task_id']);
        }
    }
	
    // Secure deletion: ensure a user can only delete their own notifications
    $stmt = mysqli_prepare($conn, "DELETE FROM notifications WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $notif_id, $user_id);
    mysqli_stmt_execute($stmt);
}
header("Location: index.php");
exit();
?>