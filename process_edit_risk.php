<?php
session_start();
include 'db.php';

$risk_id = intval($_POST['risk_id']);
$project_id = intval($_POST['project_id']);
$description = $_POST['description'];
$category = $_POST['category'];
$probability = intval($_POST['probability']);
$impact = intval($_POST['impact']);

$stmt = mysqli_prepare($conn, "UPDATE risks SET description=?, category=?, probability=?, impact=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "ssiii", $description, $category, $probability, $impact, $risk_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: projects.php?tab=risk&id=$project_id");
    exit();
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}
?>