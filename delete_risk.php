<?php
session_start();
include 'db.php';

$risk_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;

if ($risk_id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM risks WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $risk_id);
    mysqli_stmt_execute($stmt);
}

header("Location: projects.php?tab=risk&id=$project_id");
exit();
?>