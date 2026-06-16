<?php
session_start();
include 'db.php';

if (isset($_GET['notif_id'])) {
    $notif_id = intval($_GET['notif_id']);
    $user_id = intval($_SESSION['user_id']);

    // Secure deletion: ensure a user can only delete their own notifications
    $stmt = mysqli_prepare($conn, "DELETE FROM notifications WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $notif_id, $user_id);
    mysqli_stmt_execute($stmt);
}

// Redirect straight back to your main dashboard index page
header("Location: index.php");
exit();
?>